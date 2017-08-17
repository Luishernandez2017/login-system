<?php
namespace App;
use \App\Config;

/**
* Unique random tokens
*
* PHP version 7.1.6
*/

class Token{
    /**
    * The token value
    *
    * @var array
    */
    protected $token;



    /**
    * Class constructor. Create a new ranom token.
    *
    * @return void
    */
    public function __construct($token_value = null){

        if($token_value){
            $this->token = $token_value;
        }else{
        $this->token =  bin2hex(random_bytes(16)); //16 bytes = 128 bits = 32 characters
        }
    }


    /** 
    * Get the token value
    *
    * @return string The value
    */
    public function getValue(){
        return $this->token;
    }

    /** 
    * Get the hashed token value
    *
    * @return string the hashed value
    */
    public function getHash(){
        return hash_hmac('sha256', $this->token, Config::TOKEN_KEY);//sha256 = 64 characters
    }

}



?>