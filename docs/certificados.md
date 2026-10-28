# Certificados de ConserpMDD

En `/admin/certificados`, registra el participante, el curso o capacitación, la fecha de emisión y una imagen JPG, PNG o WebP (hasta 8 MB). El curso del catálogo es opcional: puedes escribir cualquier capacitación. Las observaciones y la imagen se muestran públicamente al publicar el registro; utiliza documentos destinados a la verificación pública.

Al guardar se genera un código único permanente, el enlace público y el QR. El formulario muestra el enlace seleccionable, la vista previa del QR y botones de descarga PNG y SVG. El SVG conserva su calidad al imprimir. En local, “Ver validación” abre la página local; el enlace compartido y el QR apuntan al dominio público.

Estados:

- **Borrador:** ni el registro ni su imagen son accesibles públicamente.
- **Válido:** el registro y la imagen son públicos por código. Si tiene fecha de vencimiento, aparece como vencido desde el día siguiente.
- **Revocado:** el mismo enlace muestra que el certificado ya no es válido. Se conserva el documento como respaldo del registro.

Se evita la eliminación desde el panel para conservar la trazabilidad de los QR impresos. El código no se puede modificar, y eliminar un curso del catálogo no elimina sus certificados.

## Publicación

Configura en el hosting:

```dotenv
APP_URL=https://conserpmdd.com
CERTIFICATES_PUBLIC_URL=https://conserpmdd.com
```

El segundo valor controla el destino del QR y del enlace compartido. Su valor por defecto es `https://conserpmdd.com`. Mantén este dominio y las rutas disponibles mientras existan certificados emitidos; cambiarlo no actualiza los QR ya impresos. La compra del dominio por sí sola no publica la aplicación.

Instala las dependencias del archivo `composer.lock`, ejecuta `php artisan migrate --force` y reconstruye las cachés con `php artisan filament:optimize`, `php artisan optimize` y `php artisan view:cache`. PHP necesita GD para generar PNG. No se necesita Node ni servicios externos para generar los QR.

Los documentos se almacenan en `storage/app/certificates/evidence` fuera de la carpeta pública. Se entregan mediante rutas que comprueban el estado del registro. Incluye esta carpeta y la base de datos en los respaldos al trasladar el proyecto al hosting; Git no contiene estos archivos ni los registros.

El portal `/certificados` permite consultar un código. Cada QR abre directamente `/certificados/CMDD-...`. No hay un directorio público de participantes ni de certificados.
