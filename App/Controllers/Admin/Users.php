<?php

namespace App\Controllers\Admin;

use \Core\Controller;
/*** Users Admin Controller ***/

class Users extends Controller{
    
    /**
    * Before filter - called before an action method
    *
    * @return void 
    */
    protected function before(){
        echo "(before)";
        //return false;//useful for authentication
        
    }

    /**
    * after filter - called after an action method
    *
    * @return void 
    */
    protected function after(){
        echo "(after)";
        
    }

      /**
        * Show the index of page
        *
        * @return void
        */

    public function indexAction(){
        echo 'Hello from the Admin index action in the Posts controller';
       
    }


    

}




?>