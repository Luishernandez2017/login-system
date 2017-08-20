<?php
 namespace App;
 use \App\Config;
 use PHPMailer;
 use \App\Flash;

 

 class Mail {

    /**
    * Send a message
    *
    * @param string $to Recipient
    * @param string $subject Subject
    * @param string $text Tex-only content of the message
    * @param string $html HTML content of the message
    *
    * @return mixed
    */

    public static function send($to, $subject, $textBody, $html=false){
        $mail = new PHPMailer();
        
            
    //$mail->SMTPDebug = 3;   // Enable verbose debug output
    
    //Set Mailer to use SMTP
    $mail->isSMTP(); 
         
    //Enable SMTP authentication
    $mail->SMTPAuth = Config::SMT_AUTH;  
    

    //use GMAIL server
    $mail->Host = Config::MAIL_HOST;  

    //SMTPsecure tls/ssl
    $mail->SMTPSecure = Config::SMTP_SECURE; 

    $mail->Port = Config::MAIL_PORT;

    // SMTP username
    $mail->Username = Config::SMTP_USERNAME;       
    
    // SMTP password
    $mail->Password = Config::SMTP_PASSWORD;     

    //Senders email
    $mail->SetFrom( Config::SENDER_EMAIL);



    $mail->addAddress($to); //Recipient
    $mail->Subject= $subject; // Email Subject
    $mail->isHTML($html);  // HTML boolean
    $mail->Body =$textBody; //Email body


    $mail->send();
      

    if(!$mail->send()){

        Flash::addMessage('Email could not be sent.', Flash::DANGER);
        throw new \Exception('Mailer Error: ' . $mail->ErrorInfo);

    }else{

        // Flash::addMessage('Email has been sent.', Flash::SUCCESS);

    }


    }

 }



?>