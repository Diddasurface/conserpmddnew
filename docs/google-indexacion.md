# Indexación de ConserpMDD en Google

## Archivos y metadatos

- `public/robots.txt`: permite rastrear las páginas públicas, evita el rastreo de `/admin`, `/api/` y `/livewire/`, y anuncia el sitemap.
- `public/sitemap.xml`: incluye únicamente `/`, `/nosotros` y `/contactanos`. Los cursos y servicios actuales son secciones de Inicio, no páginas independientes.
- `resources/views/recursos/seo.blade.php`: genera título y descripción, URL canónica, Open Graph, Twitter Card y datos estructurados Organization/WebSite con el nombre y teléfono de la empresa.
- Las páginas públicas permiten indexación con `APP_ENV=production`. En local conservan `noindex`.
- Los certificados, sus imágenes/PDF y el panel mantienen `noindex`. Se omiten del sitemap. Los comprobantes se sirven con `X-Robots-Tag: noindex, nofollow`.

Las rutas de certificados no se bloquean en robots.txt: Google necesita poder rastrearlas para leer la instrucción `noindex`. Esto no cambia la publicación, los enlaces ni los QR. El acceso a los borradores sigue protegido por la aplicación.

## Actualizar EC2

```bash
cd /var/www/html/conserpmdd
sudo -u ubuntu git pull --ff-only origin master
sudo -u ubuntu php8.3 artisan optimize
sudo -u ubuntu php8.3 artisan view:cache
```

Comprueba que `APP_ENV=production`, `APP_DEBUG=false` y `APP_URL=https://conserpmdd.com` estén configurados en `.env`.

Abre:

- `https://conserpmdd.com/robots.txt`
- `https://conserpmdd.com/sitemap.xml`
- `https://conserpmdd.com/`

## Registrar la web en Google Search Console

1. Abre [Google Search Console](https://search.google.com/search-console/) con tu cuenta Google.
2. Añade una propiedad de tipo **Dominio**: `conserpmdd.com`.
3. Copia el registro TXT de verificación proporcionado por Google y agrégalo en el proveedor DNS del dominio. Conserva los registros A, CNAME y de correo existentes.
4. Cuando el registro se haya propagado, pulsa **Verificar** en Search Console. Conserva ese TXT después de verificar.
5. En **Sitemaps**, envía `https://conserpmdd.com/sitemap.xml`.
6. En **Inspección de URLs**, inspecciona `https://conserpmdd.com/`, ejecuta la prueba de la URL publicada y solicita su indexación. Puedes hacer lo mismo con `/nosotros` y `/contactanos`.
7. Consulta después los informes de indexación. Google decide qué páginas indexar y cuándo; el sitemap no garantiza aparecer ni fija una posición.

Si eliges una propiedad de **Prefijo de URL** en lugar de Dominio, utiliza `https://conserpmdd.com/`. Para verificarla con etiqueta HTML, copia solo el valor `content` de la etiqueta de Google en `.env`:

```dotenv
GOOGLE_SITE_VERIFICATION=valor_entregado_por_google
```

Después ejecuta `sudo -u ubuntu php8.3 artisan config:cache` y vuelve a verificar. Esta variable es opcional si utilizas la verificación DNS.

## Mantener el sitemap

Al crear nuevas páginas públicas reales, incorpora sus URLs definitivas HTTPS a `public/sitemap.xml`. No agregues URLs de administración, documentos ni códigos personales. Las páginas de demostración `.html` no tienen rutas Laravel y no forman parte del sitemap.

El dominio canónico se configura en `config/seo.php`; el sitemap y robots.txt utilizan el mismo dominio. Mantén los tres alineados si cambia la dirección pública.

Referencias: [Google: crear y enviar sitemaps](https://developers.google.com/search/docs/crawling-indexing/sitemaps/build-sitemap), [Google: noindex](https://developers.google.com/search/docs/crawling-indexing/block-indexing), [Google: solicitar nuevo rastreo](https://developers.google.com/search/docs/crawling-indexing/ask-google-to-recrawl).
