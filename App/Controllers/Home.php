<?php

namespace App\Controllers;

use \Core\View;
use \Core\Controller;
use \App\Auth;
use \App\Mail;

/** Home Controller **/

    class Home extends Controller{
        /**
        * Show the index of page
        *
        * @return void
        */


    public function indexAction(){

        // Mail::send('mijnwerkruimte@gmail.com', 'Test', '<h1>this is a test</h1>', true);


           View::renderTemplate('Home/index.html',[]);
    }

 


    }



?>