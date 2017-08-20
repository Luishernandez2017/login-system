<?php

namespace App\Controllers;
use \App\Models\User;
use \Core\Controller;



/** Account Controller **/

    class Account extends Controller{

        /**
        * Validate if email is available(AJAX) for a new signup
        *
        * @return void
        */

        public function validateEmailAction(){
            $is_valid =  ! User::emailExists($_GET['email'], $_GET['ignore_id'] ?? null);

            header('Content-type: application/json');
            echo json_encode($is_valid);

        }
        

    }



?>