# Arquitectura Bàsica

* **Back-end (servidor)**: Utilitzem Laravel com a API per gestionar la comunicació amb una base de dades. Aquesta API és responsable de servir tota la informació que necessita el front-end, així com de gestionar operacions com la creació, lectura, actualització i eliminació de dades (CRUD).
* **Front-end (client)**: Utilitzem Vue 3 per gestionar la interfície d'usuari. Vue s'encarrega de la part interactiva i visual de l'aplicació, proporcionant una experiència d'usuari dinàmica i reactiva.
* **Part d'Administració**: Laravel també s'utilitza per a la part d'administració, on es permet als usuaris gestionar el CRUD dels productes (afegir, editar, eliminar i visualitzar productes) a través d'una interfície.

## Tecnologies
* **Vue 3**: Framework JavaScript per crear interfícies d'usuari reactives i components reutilitzables.
* **Laravel 11**: Framework PHP que facilita el desenvolupament d'aplicacions web robustes, amb una sintaxi elegant i orientada a objectes.
* **JavaScript**: Llenguatge de programació utilitzat per afegir interactivitat i comportament a l'aplicació al front-end.
* **CSS**: Utilitzat per estilitzar la interfície d'usuari, millorant la presentació visual de l'aplicació.
* **PHP 8**: Llenguatge de programació utilitzat al back-end, especialment per a Laravel.
* **HTML**: Llenguatge de marcat per estructurar les pàgines web al front-end.

## Plugins
* Per fer proves i verificar que la comunicació amb l'API funcioni correctament quan es realitzen peticions HTTP, hem utilitzat:
    * **Thunder Client**: Plugin de VS Code que permet realitzar peticions HTTP des de l'editor.
    * **Postman**: Eina per provar API's de manera fàcil i visual, permetent enviar peticions HTTP i veure les respostes.

## Com Desplegar l'Aplicació a l'Entorn de Desenvolupament
Segueix aquests passos per configurar i executar l'aplicació en un entorn de desenvolupament:

1. **Instal·lació de Dependències**:
   * Accedeix al directori `takeAway-back` i executa `composer install` per instal·lar totes les dependències necessàries per a Laravel.

2. **Configuració de l'Arxiu `.env`**:
   * Crea una còpia de l'arxiu `.env.example` i anomena'l `.env`.
   * Dins del `.env`, defineix les configuracions de la base de dades descomentant i ajustant les següents línies:
     ```env
     DB_HOST=el_teu_host
     DB_PORT=el_teu_port
     DB_DATABASE=el_nom_de_la_teva_base_de_dades
     DB_USERNAME=el_teu_usuari
     DB_PASSWORD=la_teva_contrassenya
     ```
   * Substitueix `el_teu_host`, `el_teu_port`, `el_nom_de_la_teva_base_de_dades`, `el_teu_usuari` i `la_teva_contrassenya` pels valors corresponents del teu entorn.

3. **Iniciar el Servei del Servidor de Base de Dades**:
   * Assegura't que el servei de la base de dades (per exemple, MySQL o MariaDB) estigui en funcionament i crea la base de dades especificada al fitxer `.env`.

4. **Migracions, Generació de Clau i Inserció de Dades**:
   * Per configurar les taules a la base de dades, genera la clau de l'aplicació i insereix dades de mostra:
     * `php artisan key:generate`: Genera una clau única per a l'aplicació en l'arxiu `.env`, necessària per a la seguretat.
     * `php artisan migrate:rollback`: Esborrarà totes les taules existents si n'hi ha, preparant la base de dades per començar de nou.
     * `php artisan migrate:reset`: Alternativa a `rollback` que elimina les migracions aplicades i deixa la base de dades com si fos nova.
     * `php artisan migrate`: Crea les taules a la base de dades segons les migracions definides.
     * `php artisan import:products`: Inserirà dades a les taules, per exemple, productes predefinits que vulguis tenir disponibles a l'aplicació.

5. **Neteja de Caché**:
   * Per evitar problemes de configuració i garantir que es carreguin els últims canvis, neteja el caché amb aquests camandes:
     * `php artisan config:clear`: Neteja la caché de la configuració.
     * `php artisan view:clear`: Neteja la caché de les vistes de Blade.
     * `php artisan cache:clear`: Neteja la caché general de l'aplicació.

6. **Iniciar el Servidor de Laravel**:
   * Per executar l'aplicació i accedir a ella des del teu navegador, inicia el servidor de desenvolupament de Laravel amb:
     ```bash
     php artisan serve
     ```
   * Per producció, pot ser més adient configurar un servidor web com Nginx o Apache.

## Com Desplegar l'Aplicació a Producció
Segueix aquests passos per configurar i executar l'aplicació en un entorn de producció:

1. **Preparar i Pujar el Projecte**:
   * Comprimeix la carpeta del projecte.
   * Puja el fitxer comprimit al servidor.

2. **Estructuració de Fitxers**:
   * Descomprimeix el projecte.
   * Mou la carpeta `web` a `public_html`.
   * Mou la carpeta `back` a una ubicació segura, com `private`.
   * Mou la carpeta `public` (dins de `back/takeAway-back`) a `public_html`.

3. **Configuració del Fitxer `.env`**:
   * Copia el fitxer `.env.example` i renombra'l com `.env`.
   * Configura les credencials de la base de dades i altres variables segons el teu entorn de producció.

4. **Modificar el Fitxer `index.php`**:
   * A l'arxiu `index.php` dins de `public_html`, modifica les rutes per apuntar correctament a la ubicació del back-end.
   * Copia la ruta completa fins a `private/back/takeAway-back/` i substitueix totes les referències que comencin amb `..` amb la nova ruta copiada.

5. **Actualitzar `communicationManager` per a la Comunicació d'API**:
   * Dins de `public_html/web/js`, obre `communicationManager` i assegura't que la URL apunti correctament a `/public/api/el_que_sigui`.

6. **Configuració de la Base de Dades**:
   * Crea una nova base de dades.
   * Importa les dades des del fitxer `takeOutFit.sql` dins la base de dades creada.

7. **Actualitzar `utils.js` per les Variables d'Entorn**:
   * Obre `utils.js` i canvia la variable d'entorn `laravel` perquè apunti a la ruta `/public`.

## Consideracions Finals
* **Verifica les Configuracions d'Entorn**: Assegura't que les configuracions de l'arxiu `.env` coincideixin amb l'entorn on es desplega l'aplicació (producció o desenvolupament).
* **Seguretat**: Mai comparteixis l'arxiu `.env` públicament, ja que conté informació sensible com les credencials de la base de dades.
* **Optimització**: Si estàs desplegant en un entorn de producció, pots utilitzar `php artisan config:cache` per millorar el rendiment un cop estigui tot configurat correctament, però fes-ho només quan no estiguis fent canvis freqüents a les configuracions.
