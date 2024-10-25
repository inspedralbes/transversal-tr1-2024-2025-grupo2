# Arquitectura bàsica

* A la part del Back-end tenim un Laravel que ens fa d'API que ens serveix la informació d'una base de dades.
* Al Front-end en la part del client tenim VUE que s'encarrega de la vista de l'usuari.
* A la part d'Administrador tenim a Laravel com a framework que permet visualitzar un CRUD pels productes.

## Tecnologies
* VUE 3
* Laravel
* JavaScript
* CSS
* PHP 8
* HTML

## Com despegar l'aplicació a produccio
1. Dins d'el directori `takeAway-back`, executar `composer install` per instal·lar les dependencies.
2. Fes una copia del fitxer `.env.example` i anomena'l `.env`, dins d'aquest descomenta DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME i DB_PASSWORD.
    * Canvia els paràmetres pels teus propis.
3. Iniciar el servei del servidor de base de dades i crear la base de dades especificada anteriorment.
4.  Per crear les taules i també inserta les dades:
    * Executar `php artisan migrate:rollback` per esborrar totes les taules
    * Executar `php artisan migrate` per insertar les taules a la base de dades.
    * Executar `php artisan import:products` per insertar les dades a les taules corresponents.
5. Netejar el cache: 
    * `php artisan config:clear` 
    * `php artisan view:clear` 
    * `php artisan cache:clear`
6. Iniciar el servidor de laravel `php artisan serve;`