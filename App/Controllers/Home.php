<?php

namespace App\Controllers;

use \Core\View;
use \Core\Controller;
use \App\Auth;

/** Home Controller **/

    class Home extends Controller{
        /**
        * Show the index of page
        *
        * @return void
        */


    public function indexAction(){


           View::renderTemplate('Home/index.html',[]);
    }

 


    }



?>