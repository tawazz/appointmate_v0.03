<?php
    ini_set('date.timezone','Australia/Perth');
    // Using composer.phar for dependancies... again, however you want to install the SwiftMailer library 
    require_once('../lib/autoload.php');
    // Our iCalendar library
    require_once 'ical.php';

    class Mail{

        public function __construct(){

        }
        public function send($to=array(),$subject,$message_body,$bounces){
            $message = Swift_Message::newInstance()
              ->setSubject($subject)
              ->setFrom(array("app@ec2-54-206-61-227.ap-southeast-2.compute.amazonaws.com" => "AppointMate"))
              ->setReturnPath($bounces)
              ->setTo($to);

            $message->setBody($message_body,'text/html');

            $transport = Swift_SmtpTransport::newInstance('mail.tawazz.net',587)
                ->setUsername('appointmate@tawazz.net')
                ->setPassword('z^mPHnbgVZon');

            $mailer = Swift_Mailer::newInstance($transport);
            $result = $mailer->send($message, $failures);
        }
    }
?>