## Prueba técnica Laravel Bodytech
- Laravel 8
- PHP 7.4
- mySQL
- Api Rest.

## Configuración del proyecto de prueba.

1. Clonar repositorio
2. Insalacion de dependencias *[composer install]*
3. Copiar archivo de configuracion .env.example en el archivo de configuración del proyecto
4. Crear y configurar instancia de DB en el archivo de configuración
5. Creación de clave del proyecto *[php artisan key:generate]*
6. Ejecutar migraciones de la aplicación *[php artisan migrate:status]* verificar estado de las migraciones y ejecutar *[php artisan migrate]*
7. Levantar servidor local *[php artisan serve]*


## Configuracion de Tests/DB Testing
1. Crear y configurar instancia de DB nombrada: *[bodytech-tests]* en el archivo de configuración *phpunit.xml*
2. Ejecutar pruebas unitarias: *[php artisan test]*
3. Tests realizados end endpoints de productos y autenticación login|register


