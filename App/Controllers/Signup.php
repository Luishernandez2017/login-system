<?php

namespace App\Controllers;
use \App\Config;
use \Core\View;
use \Core\Controller;
use \App\Models\User;


/** Home Controller **/

    class Signup extends Controller{
        /**
        * Show the index of page
        *
        * @return void
        */


    /**
    * Before filter - called before an action method
    *
    * @return void 
    */
    protected function before(){
 
        
    }

    /**
    * after filter - called after an action method
    *
    * @return void 
    */
    protected function after(){
       
        
    }

    /**
    * render template index.html
    *
    * @return void
    */

    public function indexAction(){


           View::renderTemplate('Signup/index.html', [
            'name'    => 'Dave',
            'colours' => ['red', 'green', 'blue']
        ]);
    }

    /**
    * create new user
    * construct new user
    *
    * @param $_POST
    *
    * @return
    */
    public function createAction(){
         $user = new User($_POST);
       
       if($user->save()){

            $user->sendActivationEmail();

            $this->redirect('signup/success');
 
       // header('Location:'.Config::ROOT_URL.Config::ROOT_PATH.'success', true, 303);
        exit;

       }else{

           View::renderTemplate("Signup/index.html", [
           'user'=> $user
           ]);
       }


    }//end of createAction function

    /**
    * Show the signup success page
    * 
    * @return void
    */
    public function successAction(){

        View::renderTemplate('Signup/success.html');
    }

    /**
    * Activate a new account
    * 
    * @return void
    */
    public function activateAction(){
        User::activate($this->route_params['token']);
        $this->redirect('signup/activated');
    }
    
    /**
    * Show the activation success page
    *
    * @return void
    */
    public function activatedAction(){
        View::renderTemplate('Signup/activated.html');
    }

 


    }



?>