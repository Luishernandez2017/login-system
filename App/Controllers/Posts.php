<?php

namespace App\Controllers;
use \Core\View;
use \Core\Controller;
use \App\Controllers\Authenticated;
use  \App\Models\Post;
/** Post Controller **/

    class Posts extends Authenticated{


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
        * Show the index of page
        *
        * @return void
        */

    public function indexAction(){
        $posts = Post::getAll();
       //  View::render('Posts/index.php');
         View::renderTemplate('Posts/index.html', [
             'posts'=> $posts
         ]);
    }

    /**
    * Show the add new page
    *
    * @return void
    */

    public function addNewAction(){
        echo 'Hello from the addNew action in the Posts controller';
    }

       /**
     * Show the edit page
     *
     * @return void
     */
    public function editAction()
    {
        echo 'Hello from the edit action in the Posts controller!';
        echo '<p>Route parameters: <pre>' .
             htmlspecialchars(print_r($this->route_params, true)) . '</pre></p>';
    }

   

    }



?>