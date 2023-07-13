## Instrucciones para ejecutar correctamente la prueba técnica:
1. Una vez instalado el proyecto ejecute el comando: composer install
2. Luego de esto ejecute el comando npm install. En algunos casos es más recomendable ejecutarlo como admin así: sudo npm install
3. Ejecute el comando: php artisan adminlte:install y a la pregunta de: The config file already exists. Want to replace it? (yes/no) [no]: le coloca "NO" sin las comillas.
4. Recuerde crear el archivo .env por si no le aparece (en caso contrario no es necesario) y reemplazar los valores de acceso a la base de datos con los valores de su base de datos MySQL local.
5. Por último ejecutar el comando: php artisan serve
