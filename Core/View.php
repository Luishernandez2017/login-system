<?php
namespace Core;
use \App\Auth;
use \App\Flash;


class View{
    /**
    * Render a view file
    *
    * @param string $view The view file
    *
    * @return void
    */
    public static function render($view, $args=[]){

        extract($args, EXTR_SKIP);//associtive array to individual variables

        $file = "../App/Views/$view";  //relative to Core directory

        if(\is_readable($file)){
            require($file);
        }else{
           // echo  " {$file} not found";
           throw new \Exception("$file not found");
        }
    }


    /**
     * Render a view template using Twig
     *
     * @param string $template  The template file
     * @param array $args  Associative array of data to display in the view (optional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__).'/App/Views/');
            $twig = new \Twig_Environment($loader);
            //$twig->addGlobal('session', $_SESSION);
            //$twig->addGlobal('is_logged_in', Auth::isLoggedIn());
             $twig->addGlobal('current_user', Auth::getUser());      
             $twig->addGlobal('flash_messages',Flash::getMessages());      
        }

        echo $twig->render($template, $args);
    }
}




?>