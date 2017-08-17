<?php

namespace Core;

    class Error{

        /**
        * Error Handler. Convert all errors to Exceptions by throwing an ErrorException.
        *
        * @param int $level Error level
        * @param string $message Error message
        * @param string $file Filename the error was raised in
        * @param int $line Line number int the file
        *
        * @return void
        */

        public static function errorHandler($level, $message, $file, $line){
            if(error_reporting() !== 0){
                //to keep @operator working
                throw new \ErrorException($message, 0, $level, $file, $line);
            }
        }


        /**
        * Exception handler.
        *
        * @param Exception $exception The exception
        *
        * @return void
        */
        public static function exceptionHandler($exception){
            $code = $exception->getCode();
            if($code != 404){
                $code = 500;
            }

            //return response
            http_response_code($code);

            if(\App\Config::SHOW_ERRORS){//check Config.php
                echo "<h1>Fatal error </h1>";
                echo "<p>Uncaught exception: '". get_class($exception)."'</p>";
                echo "<p>Message: '".$exception->getMessage()."'</p>";
                echo "<p>Stack Trace:<pre>". $exception->getTraceAsString()."</pre></p>";
                echo "<p>Thrown in '".$exception->getFile()."' on line: ". $exception->getLine()."</p>";
            }else{
                $log = dirname(__DIR__).'/logs/'. date('Y-m-d');
                ini_set('error_log', $log);

                $message = "Uncaught exception: '". get_class($exception) ."'";
                $message .= " with message '".$exception->getMessage()."'";
                $message .= "\n Stack trace: ". $exception->getTraceAsString();
                $message .= "\n Thrown in '". $exception->getFile(). "' on line: ". $exception->getLine();

                error_log($message);
                // if($code == 404){
                //     echo "<h1> Page not Found</h1>";
                // }else{
                //     echo "<h1>An error occurred</h1>";

                // }

                View::renderTemplate("$code.html");
               
            }
        }

    }


    




?>