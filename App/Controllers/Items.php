<?php
namespace App\Controllers;
use \Core\Controller;
use \App\Controllers\Authenticated;
use \Core\View;
use \App\Auth;



/**
* Itmes controller(example)
*/
class Items extends Authenticated{

    /**
    * Items index
    *
    * @return void
    */

    public function indexAction(){

        View::renderTemplate('Items/index.html');
        

        

    }

}



?>