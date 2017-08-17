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
        const DB_USER ="Alexander";

        /**
        * Database password
        *@var string
        */
        const DB_PASS ="Great";

        /**
        * Show or hide error message on screen
        * @var string
        */
        const SHOW_ERRORS = false;

        /**
        * Root_Path
        * @var string
        */
         const ROOT_PATH= '/PHP-course/Udemy%20PHP/PHP_FRAMEWORK/MVC2/MVC_Login_System/public/';
       
       
        /**
        * Root_Url
        * @var string
        */
        const ROOT_URL ='http://localhost';

        /**
        * Token key
        * @var string
        */
        //const TOKEN_KEY ="ZvXh36IP6MuuEhs5i3NapHdreZIqiTFQ";
        const TOKEN_KEY ="topsecret";

          /**
        * Cookie path
        * @var string
        */
         const COOKIE_PATH= '/PHP-course/Udemy%20PHP/PHP_FRAMEWORK/MVC2/MVC_Login_System/';
    }




?>