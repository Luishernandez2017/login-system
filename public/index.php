<?php 
/**
 * Composer
 */
 require '../vendor/autoload.php';

/**
* Error and Exception handling
*
*/
error_reporting(E_ALL);//php error settings
set_error_handler("Core\Error::errorHandler");
set_exception_handler("Core\Error::exceptionHandler");

/**
* Sessions
*/
session_start();


/**
* Routing
*/
$router = new Core\Router();





// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']); 
$router->add('signup', ['controller' => 'Signup', 'action' => 'index']); 
$router->add('login', ['controller' => 'Login', 'action' => 'index']); 
$router->add('logout', ['controller'=> 'Login', 'action'=>'destroy']);
//token: hexidecimail only numbers and letters a-f
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action'=> 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);

$router->add('{controller}/{action}');


$router->dispatch($_SERVER['QUERY_STRING']);

?>