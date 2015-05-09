<?php
    require_once("db.php");
    require_once("booking.php");
    require_once("Mail.php");
    require_once("ical.php");
    // Using composer.phar for dependancies... again, however you want to install the SwiftMailer library
    $root = realpath($_SERVER["DOCUMENT_ROOT"]);
    require_once($root.'/apointmate/lib/autoload.php');
        class Attendee{
            
            private $db;
            private $id=NULL;

            public function __construct(){
                $this->db = DB::connect();
            }

            public function create($fields= array()){
                if(!$this->db->insert('attendee',$fields)){
                    throw new Exception('creating user failed');
                }
                $attendeeId = $this->db->lastIndex();
                $this->sendMeetingInvite($fields["FirstName"],$fields["LastName"],$fields["email"],$fields["bookingId"],$attendeeId);
            }

            private function sendMeetingInvite($fname,$lname,$email,$bookingId,$attendeeId){
                    $booking = new Booking($bookingId);
                    $to = $email;
                    $subject = $booking->name();
                    $message = "Dear ".$fname." ".$lname."<br/>";
                    $message .= "<p>".$booking->getDescription() ."</p>";
                    $message .= "<a href='http://tawazz.net/apointmate/meetings.php?BookingId={$bookingId}&AttId={$attendeeId}'>Click here<a/> to choose your meeting";
                    $message .= "<p> Yours Sincerely </p> <br/>";
                    $message .= $booking->getOrganizer() ."<br/> Contact : ". $booking->getOrganizerEmail(); 

                    $sendEmail = Swift_Message::newInstance()
                      ->setSubject($subject)
                      ->setFrom(array("app@ec2-54-206-61-227.ap-southeast-2.compute.amazonaws.com" => "AppointMate"))
                      ->setReturnPath($booking->getOrganizerEmail())
                      ->setTo(array($to => $fname." ".$lname));

                    $sendEmail->addPart( $message,'text/html');

                    $transport = Swift_SmtpTransport::newInstance('mail.tawazz.net',587)
                        ->setUsername('appointmate@tawazz.net')
                        ->setPassword('z^mPHnbgVZon');

                    $mailer = Swift_Mailer::newInstance($transport);
                    $result = $mailer->send($sendEmail, $failures);  
            }
            
            public function sendConfirmation(){
                
            }
            public function getAttendee($id){
                $q = $this->db->connect()->get("attendee",array("Id","=",$id));

                $result= $q->first();

                return $result->FirstName." ".$result->LastName;
            }
        }
?>