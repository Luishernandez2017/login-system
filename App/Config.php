<?php
 namespace App;

    /*** Application configuration ***/


    class Config {
        /**
        * Database host
        * @var string
        */
        const DB_HOST = 'localhost';

        /**
        * Database name
        *@var string
        */
        const DB_NAME ="mvc";

        /**
        * Database username
        *@var string
        */
        const DB_USER ="root";

        /**
        * Database password
        *@var string
        */
        const DB_PASS ="";

        /**
        * Show or hide error message on screen
        * @var string
        */
        const SHOW_ERRORS = false;

        /**
        * Root_Path
        * @var string
        */
         const ROOT_PATH= '/';
       
       
        /**
        * Root_Url
        * @var string
        */
        const ROOT_URL ='http://localhost';

        /**
        * Token key
        * @var string
        */
        const TOKEN_KEY ="ZvXh36IP6MuuEhs5i3NapHdreZIqiTFQ";


          /**
        * Cookie path
        * @var string
        */
         const COOKIE_PATH= '/';
    }




?>
