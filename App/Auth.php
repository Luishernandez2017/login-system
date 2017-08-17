<?php
namespace App;

use \App\Config;
use \App\Models\User;
use \App\Models\LoginToken;

/**
* Authentication
*
*/

class Auth{

    /**
    * Login the user
    * 
    * @param User $user the user model
    *
    * @return void
    */

    public static function login($user, $remember_me){
               
            //Prevent cross-site attacs (session fixation attacks)
            //regenerates a new session_id everytime login occurs
            session_regenerate_id(true);
            $_SESSION['user_id']= $user->id;

            // if checkbox is checked
            if($remember_me){

                // if statement query is successful
                if($user->rememberLogin()){

                    //set a cookie with a path to make it available through whole site
                    setcookie('remember_me', $user->remember_token, $user->expiry_timestamp, Config::COOKIE_PATH);


                }
            }
    }

    /**
    * Logout the user
    *
    * @return void
    */
    public static function logout(){
          // Unset all of the session variables.
        $_SESSION = [];

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();


            setcookie(session_name(), 
            '', 
            time() - 42000,
            $params["path"], 
            $params["domain"],
            $params["secure"], 
            $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
        static::forgetLogin();
    }

    // /**
    // * Return indeicator of whether a user is logged in or not
    // *
    // * @return boolean
    // */
    // public static function isLoggedIn(){
    //     return isset($_SESSION['user_id']);
    // }

    /**
    * Remember the originally-requested page in the session
    *
    * @return void
    */

    public static function rememberRequestedPage(){
    $_SESSION['return_to']= $_SERVER['REQUEST_URI'];

        
    }

    /**
    * Get the originlly requested page to return to after requiring login, or default to the hompage;
    *
    * @return void
    */
    public static function getReturnToPage(){
        return $_SESSION['return_to'] ?? '';
    }
    
    /**
    * Get the current logged-in user, from the sesssion or the remember-me cookie
    *
    * @return mixed The user model or null in not logged in
    */
    public static function getUser(){

        if(isset($_SESSION['user_id'])){

          return User::findByID($_SESSION['user_id']);
        }else{
            //use cookie loginToken if there is one
            return static::loginFromRememberCookie();

        }
    }


    /**
    * Login the user from a remembered login cookie
    *
    * @return mixed The user model if login coookie found; null otherwise
    */
    protected static function loginFromRememberCookie(){
      $cookie = $_COOKIE['remember_me'] ?? false;
         $token = new Token($cookie);
            $token_hash = $token->getHash();

            // var_dump($token_hash);

        if($cookie){
            $loginToken = LoginToken::findByToken($cookie);

            if($loginToken && !$loginToken->hasExpired()){

                $user = $loginToken->getUser();

                static::login($user, false);

                return $user;

            }

        }
    }

    /**
     * Forget the remembered login , if present
     *
    * @return void
    */
    protected static function forgetLogin(){

        $cookie = $_COOKIE['remember_me'] ?? false;

        if($cookie){

            $loginToken = LoginToken::findByToken($cookie);

            if($loginToken){
                $loginToken->delete();
            }
            //to delete cookie you must have exact path and domain if included when created
            // setcookie ("user", "John", time()+7200, '/', 'mydomain.com'); 
            // to delete this cookie use this code
            
            // setcookie ("user", "", time()-3600, '/', 'mydomain.com');
            setcookie ('remember_me', '', time() - 3600, Config::COOKIE_PATH); //set to expire in the past
            
        }

       
    }

    

}

?>