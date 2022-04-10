# Prueba Sesame

### Pre-requisitos 📋

Tienes que tener instalado:

Xampp 7.4.28

Composer

Symfony

### Instalación 🔧

Descarga el proyecto.

Una vez descargado descomprimelo.

Abres la consola de comandos y te mueves hasta la carpeta del proyecto, y ejecuta:
```
composer install
```

## Despliegue 📦

Ejecutamos estos comandos para generar la BBDD:

```
php bin/console doctrine:database:create
```
```
php bin/console doctrine:schema:create
```

Iniciar Proyecto:
```
symfony server:start
```
