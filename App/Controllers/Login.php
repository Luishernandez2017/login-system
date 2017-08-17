<?php

namespace App\Controllers;
use \App\Config;
use \App\Auth;
use \App\Flash;
use \Core\View;
use \Core\Controller;
use \App\Models\User;


/** Login Controller **/

class Login extends Controller{

        /**
        * Show the login page
        *
        * @return void
        */
        public function indexAction(){
         View::renderTemplate('Login/index.html');
      
    
        }

        /**
        * Log in a user
        * Set session and view
        *
        * @return void
        */

        public function createAction(){
        
     $user = User::authenticate($_POST['email'], $_POST['password_hash']);
     
        $remember_me = isset($_POST['remember_me']);//checkbox 
        if ($user) {

            Auth::login($user, $remember_me);
            //Remember the login here

            Flash::addMessage('Login Successful');

            //$this->redirect('/');
            $this->redirect(Auth::getReturnToPage(), true);

        } else {
             Flash::addMessage('Login unsuccessful, please try again.', Flash::WARNING);

            View::renderTemplate('Login/index.html', [
                'email' => $_POST['email'],
                'remember_me'=> $remember_me

            ]);
        }
   
        
        }
        
        /**
        * Destro $_SESSION and $_COOKIES
        *
        * @return void redirect to homepage
        */

        public function destroyAction(){
        

        Auth::logout();
   


        $this->redirect('login/show-logout-message');
        }


        /**
        * Show  'logged out' flash message and redirect to the homepage. to use
        * the flash messages as they use the session and at the end of the logout 
        * method (destroyAction) the session is  destroyed. So a new action
        * needs to be called in order to use the session.
        *
        * @return void
        */
        public function showLogoutMessageAction(){
              Flash::addMessage('Logged out');
              $this->redirect('');

        }





}

?>