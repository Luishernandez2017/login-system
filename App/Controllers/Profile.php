<?php
namespace App\Controllers;
use \Core\Controller;
use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Controllers\Authenticated;

    /**
    * Profile controller
    *
    * PHP version 7.1.6
    */
    class Profile extends Authenticated{

        /**
        * @Override Before filter - called before each action method
        * 
        *
        * @return void              
        */
        protected function before() {

            parent::before();//requireLogin();

            $this->user = Auth::getUser();
        }

        /**
        * Show the profile
        *
        * @return void
        */
        public function showAction(){
            
            View::renderTemplate('Profile/show.html', [
                'user' => $this->user
            ]);

        }

        /**
        * Show the form for editing the profile
        *
        * @return void
        */
        public function editAction(){
            View::renderTemplate('Profile/edit.html', [
                'user' => $this->user
            ]);
        }

        /**
        * Update the profile
        *
        * @return void
        */
        public function updateAction(){
           
        //    var_dump($_POST['password_hash']);
        //   var_dump(isset($this->password_hash));
            
            
            if($this->user->updateProfile($_POST)){
                Flash::addMessage('Changes saved');
                $this->redirect('profile/show');
            }else{
                View::renderTemplate('Profile/edit.html',[
                    'user' => $this->user
                ]);

            }
        }
    }



?>