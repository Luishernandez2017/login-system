<?php 

namespace App\Models;
use \Core\Model;
use \App\Token;
use PDO;

    /**
    * LoginToken model
    *
    * PHP version 7.1.6
    */
    class LoginToken extends Model{
       
        /**
        * Find a login token by the token
        *
        * @param string $token The login token
        *
        * @return mixed LogginToken object if found, false otherwise
        */
        public static function findByToken($token){

            $token = new Token($token);
            $token_hash = $token->getHash();
            
            $sql = "SELECT * FROM login_tokens 
            WHERE token_hash = :token_hash";

            $db = static::getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':token_hash', $token_hash, PDO::PARAM_STR);

            //return as an object LoginToken
            $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

            $stmt->execute();

            return$stmt->fetch();

            
        }

        /**
        * Get the user model associated with this login token
        *
        * @return User the user model
        */
        public function getUser(){
            
            return User::findByID($this->user_id);
        }


        /**
        * See if the remember token has expired or not, based on the current system time
        *
        * @return boolean True if the token has expired, false otherwise
        */
        public function hasExpired(){

            // expired type is less than current time?True, False
            return strtotime($this->expires_at) < time();

        }


        /**
        * Delete this model
        *
        * @return void
        */
        public function delete(){
             $sql = 'DELETE FROM login_tokens 
             WHERE token_hash = :token_hash';

             $db = static::getDB();
             $stmt = $db->prepare($sql);
             $stmt->bindValue(':token_hash', $this->token_hash, PDO::PARAM_STR);

             $stmt->execute();
            }
    }








?>