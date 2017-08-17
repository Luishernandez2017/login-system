<?php
namespace Core;
use App\Config;
use PDO;


/*** Base model ***/

abstract class Model {
    /**
    * Get the PDO database connection
    *
    * @return mixed
    */

    protected static function getDB(){
        static $db = null;

        if($db === null){
 
           
                // $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                 $dsn ="mysql:host=".Config::DB_HOST.";dbname=".Config::DB_NAME.";charset=utf8";
                 $db = new PDO( $dsn, Config::DB_USER, Config::DB_PASS);

                 //Throw an Exception when an error occurs
                 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        }
        return $db;
    }
}




?>