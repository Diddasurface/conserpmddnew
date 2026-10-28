# Publicar ConserpMDD en EC2 con Ubuntu y Apache

Destino: `/var/www/html/conserpmdd`. Sitio existente: `/var/www/html/walkinlodge`.
Dominio: `https://conserpmdd.com`. El servidor web debe servir **solo `/var/www/html/conserpmdd/public`**.

Estos pasos se ejecutan por SSH en la EC2, salvo las transferencias marcadas como locales. Se crea un VirtualHost y un pool PHP-FPM propios. Conserva la configuración del sitio existente.

## 1. Verificar el servidor e instalar requisitos

```bash
cat /etc/os-release
php -v
sudo apache2ctl -S
command -v composer
command -v certbot
apt-cache policy php8.3-fpm
```

El proyecto necesita PHP 8.2 o superior por sus dependencias bloqueadas. Los ejemplos usan PHP 8.3 y paquetes disponibles en Ubuntu 24.04. Si `apt-cache policy php8.3-fpm` no muestra un candidato, primero hay que habilitar una fuente compatible con la versión concreta de Ubuntu; no sustituyas la versión de PHP que usa Walkinglodge.

Si los paquetes están disponibles, instala los que falten:

```bash
sudo apt update
sudo apt install git unzip composer acl php8.3-cli php8.3-fpm php8.3-mysql php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-bcmath php8.3-opcache
```

Puedes reutilizar el servidor MySQL que ya tenga la EC2, creando una base y un usuario exclusivos. Si aún no hay un servidor MySQL, instala `mysql-server` o utiliza la base de datos remota que tengas configurada. No se necesita Node para ejecutar esta versión de la aplicación.

## 2. Descargar el proyecto

Antes de copiar el código dentro de `/var/www/html`, crea `/etc/apache2/conf-available/conserpmdd-private.conf` con esta protección global, que impide servir el repositorio desde otro VirtualHost:

```apache
<Directory /var/www/html/conserpmdd>
    AllowOverride None
    Require all denied
</Directory>
```

Actívala después de comprobar la sintaxis:

```bash
sudo a2enconf conserpmdd-private
sudo apache2ctl configtest
sudo systemctl reload apache2
```

Conéctate con el usuario de despliegue, por ejemplo `ubuntu`:

```bash
sudo install -d -o "$USER" -g www-data -m 2750 /var/www/html/conserpmdd
git clone --branch master https://github.com/Diddasurface/conserpmddnew.git /var/www/html/conserpmdd
cd /var/www/html/conserpmdd
cp .env.example .env
COMPOSER_BIN="$(command -v composer)"
php8.3 "$COMPOSER_BIN" install --no-dev --prefer-dist --optimize-autoloader
mkdir -p storage/app/public storage/app/certificates
```

Si el repositorio es privado, configura en la EC2 una clave de despliegue de GitHub con permiso de lectura y usa su URL SSH. No pongas tokens dentro de la URL del remoto.

## 3. Crear la base de datos

En MySQL, con una cuenta que pueda crear bases y usuarios:

```bash
sudo mysql
```

```sql
CREATE DATABASE conserpmdd CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'conserpmdd_app'@'127.0.0.1' IDENTIFIED BY 'REEMPLAZAR_POR_UNA_CLAVE_UNICA';
GRANT ALL PRIVILEGES ON conserpmdd.* TO 'conserpmdd_app'@'127.0.0.1';
EXIT;
```

Ejecuta esta creación una sola vez, sobre una base nueva. Si usas RDS u otro MySQL remoto, adapta el host y los permisos a esa conexión.

## 4. Trasladar los datos locales, si quieres conservarlos

Git lleva el código, pero no lleva los cursos guardados en la base, certificados ni archivos subidos. Para conservar los códigos y QR ya emitidos, exporta **la base completa `conserpmdd`**, incluyendo la tabla `migrations`, desde HeidiSQL o phpMyAdmin. Envía ese SQL a la EC2 e impórtalo en la base nueva antes de ejecutar las migraciones:

```bash
mysql -h 127.0.0.1 -u conserpmdd_app -p conserpmdd < ~/conserpmdd.sql
```

Desde PowerShell en tu PC, adaptando la clave y la IP:

```powershell
scp -i "C:\ruta\clave.pem" "C:\ruta\conserpmdd.sql" ubuntu@IP_EC2:/home/ubuntu/conserpmdd.sql
scp -i "C:\ruta\clave.pem" -r "C:\laragon\www\conserpMDD\storage\app\public" ubuntu@IP_EC2:/var/www/html/conserpmdd/storage/app/
scp -i "C:\ruta\clave.pem" -r "C:\laragon\www\conserpMDD\storage\app\certificates" ubuntu@IP_EC2:/var/www/html/conserpmdd/storage/app/
```

Primero sube el SQL, luego ejecuta la importación anterior. La carpeta `public` dentro de `storage/app` contiene las fotos de los cursos; `certificates` contiene los comprobantes privados. Después de una importación, utiliza tus cuentas existentes. Si quieres comenzar vacío, omite la importación y crea un administrador en el paso siguiente.

## 5. Configurar Laravel y el acceso al administrador

Edita `.env` en la EC2:

```bash
cd /var/www/html/conserpmdd
nano .env
```

Configura estos valores y conserva el resto del archivo:

```dotenv
APP_NAME=ConserpMDD
APP_ENV=production
APP_DEBUG=false
APP_URL=https://conserpmdd.com
CERTIFICATES_PUBLIC_URL=https://conserpmdd.com
FILAMENT_ADMIN_EMAILS=tu-correo-administrador@example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=conserpmdd
DB_USERNAME=conserpmdd_app
DB_PASSWORD="REEMPLAZAR_POR_UNA_CLAVE_UNICA"

FILESYSTEM_DISK=local
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_COOKIE=conserpmdd_session
SESSION_SECURE_COOKIE=true
QUEUE_CONNECTION=sync
```

`FILAMENT_ADMIN_EMAILS` debe contener exactamente el correo de la cuenta que usará el administrador. Admite varios correos separados por comas. En producción, las cuentas fuera de esta lista no pueden entrar al panel ni descargar sus QR privados.

En la primera instalación:

```bash
php8.3 artisan key:generate
php8.3 artisan config:clear
php8.3 artisan migrate --force
php8.3 artisan storage:link
```

Genera la clave una sola vez y conserva la `.env` del servidor en los próximos despliegues. Si comenzaste con una base vacía, crea el usuario con el mismo correo autorizado:

```bash
php8.3 artisan make:filament-user
```

La importación ya incluye tus cursos y certificados. No es necesario ejecutar `CourseSeeder` en producción: carga las tarjetas de demostración.

## 6. Permisos y pool PHP propios

```bash
cd /var/www/html/conserpmdd
sudo chown -R "$USER":www-data storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec chmod 2770 {} \;
sudo find storage bootstrap/cache -type f -exec chmod 660 {} \;
sudo setfacl -R -m u:"$USER":rwX,g:www-data:rwX storage bootstrap/cache
sudo find storage bootstrap/cache -type d -exec setfacl -m d:u:"$USER":rwx,d:g:www-data:rwx {} \;
sudo chown "$USER":www-data .env
chmod 640 .env
```

Crea `/etc/php/8.3/fpm/pool.d/conserpmdd.conf` con:

```ini
[conserpmdd]
user = www-data
group = www-data
listen = /run/php/php8.3-conserpmdd.sock
listen.owner = www-data
listen.group = www-data
listen.mode = 0660
pm = ondemand
pm.max_children = 2
pm.process_idle_timeout = 10s
pm.max_requests = 300
php_admin_value[memory_limit] = 256M
php_admin_value[upload_max_filesize] = 10M
php_admin_value[post_max_size] = 12M
php_admin_value[max_execution_time] = 60
```

El formulario mantiene su límite de 8 MB. Este pool permite que PHP reciba el archivo completo. Ajusta `pm.max_children` según la memoria disponible y el tráfico de los dos sitios.

```bash
sudo php-fpm8.3 -t
sudo systemctl enable --now php8.3-fpm
sudo systemctl reload php8.3-fpm
```

## 7. Crear el sitio Apache

La protección del repositorio ya está activada desde el paso 2. Ahora crea `/etc/apache2/sites-available/conserpmdd.conf`, que permite servir su carpeta pública únicamente en el sitio nuevo:

```apache
<VirtualHost *:80>
    ServerName conserpmdd.com
    ServerAlias www.conserpmdd.com
    DocumentRoot /var/www/html/conserpmdd/public

    <Directory /var/www/html/conserpmdd/public>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    <FilesMatch \.php$>
        SetHandler "proxy:unix:/run/php/php8.3-conserpmdd.sock|fcgi://localhost/"
    </FilesMatch>

    ErrorLog ${APACHE_LOG_DIR}/conserpmdd-error.log
    CustomLog ${APACHE_LOG_DIR}/conserpmdd-access.log combined
</VirtualHost>
```

Activa únicamente la configuración del sitio nuevo y verifica la sintaxis antes de recargar:

```bash
sudo a2enmod rewrite proxy proxy_fcgi setenvif
sudo a2enconf conserpmdd-private
sudo a2ensite conserpmdd.conf
sudo apache2ctl configtest
sudo systemctl reload apache2
```

La elección de PHP 8.3 queda dentro del VirtualHost de ConserpMDD. No hace falta desactivar módulos PHP existentes ni habilitar una configuración PHP-FPM global para todos los sitios.

## 8. Dominio y HTTPS

En el proveedor donde administras los DNS de `conserpmdd.com`, crea:

| Tipo | Nombre | Destino |
| --- | --- | --- |
| A | @ | IP pública fija o Elastic IP de la EC2 |
| CNAME | www | conserpmdd.com |

Conserva los registros del dominio de Walkinglodge. Si existe un registro AAAA para ConserpMDD, debe apuntar a IPv6 configurada para este servidor. El Security Group de la EC2 y el firewall del servidor deben permitir HTTP 80 y HTTPS 443. Una Elastic IP evita que un cambio de IP al detener/arrancar la instancia deje el dominio apuntando a una dirección antigua.

Cuando el dominio ya resuelva a la EC2 y responda por HTTP, utiliza la instalación de Certbot que ya tenga el servidor:

```bash
sudo certbot --apache -d conserpmdd.com -d www.conserpmdd.com --redirect
sudo certbot renew --dry-run
```

Si Certbot no está instalado, sigue las [instrucciones oficiales para Apache y Ubuntu](https://certbot.eff.org/instructions?ws=apache&os=snap). Solicita ambos nombres solo cuando ambos DNS estén configurados. La cookie segura del panel requiere entrar por HTTPS.

## 9. Optimizar y comprobar

```bash
cd /var/www/html/conserpmdd
php8.3 artisan filament:optimize
php8.3 artisan optimize
php8.3 artisan view:cache
php8.3 "$COMPOSER_BIN" check-platform-reqs --no-dev
curl -I https://conserpmdd.com
```

Comprueba desde el navegador:

- La página principal de ConserpMDD y la página existente de Walkinglodge.
- `/admin`: acceso con el correo incluido en `FILAMENT_ADMIN_EMAILS`.
- `/certificados` y un código real importado de tu base local.
- La carga de un PDF o imagen y la descarga/lectura de su QR.

Si hay errores, consulta `storage/logs/laravel.log`, `/var/log/apache2/conserpmdd-error.log` y `journalctl -u php8.3-fpm`. Conserva `APP_DEBUG=false` en producción.

## 10. Próximas actualizaciones

Después de subir nuevos commits a GitHub, en la EC2 ejecuta:

```bash
cd /var/www/html/conserpmdd
git pull --ff-only origin master
COMPOSER_BIN="$(command -v composer)"
php8.3 "$COMPOSER_BIN" install --no-dev --prefer-dist --optimize-autoloader
php8.3 artisan migrate --force
php8.3 artisan filament:optimize
php8.3 artisan optimize
php8.3 artisan view:cache
```

Respalda la base y las carpetas de archivos antes de desplegar cambios. Conserva `.env`, `APP_KEY` y `storage/app`; estos datos no vienen de GitHub. `git push` actualiza el repositorio; el servidor se actualiza al ejecutar este despliegue.

Referencias: [Laravel 10: despliegue](https://laravel.com/docs/10.x/deployment), [Filament 3: producción](https://filamentphp.com/docs/3.x/panels/installation#deploying-to-production), [AWS: puertos HTTP/HTTPS](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/security-group-rules-reference.html), [AWS: Elastic IP](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/elastic-ip-addresses-eip.html).
