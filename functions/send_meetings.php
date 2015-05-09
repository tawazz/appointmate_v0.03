<?php
session_start();
require_once("../classes/booking.php");
require_once("../classes/Attendee.php");
require_once("../classes/Session.php");


if(isset($_POST["times"])){
    //selected meeting times
    $times= $_POST["times"];

    if(isset($_POST['bookingId'])){
        //create booking object from booking id
        $bookingId = $_POST['bookingId'];
        $booking = new Booking($bookingId);
    }else{
        die("booking id not set");
    }
    if(isset($_POST['file'])){
        //gets the temperal csv file
        $file = $_POST['file'];
    }else{
       die("file not set"); 
    }
}else{
    die("no times selected");
}

$handle = fopen($file,"r");      
//loop through the csv file
$att = new Attendee();
$i =0;
do { 
    if ($i>1) {
        if(strlen($data[0])>0 &&strlen($data[1])>0 &&strlen($data[2])>0 &&strlen($data[3])>0) {
            try{
                $att->create(
                    array("otherId"=>$data[0],
                    "FirstName"=>$data[1],
                    "LastName"=>$data[2],
                    "email"=> $data[3],
                    "bookingId"=> $bookingId 
                    )
                ); 
            } catch(Exception $e){
                die( $e->getMessage());
            }
        }  
    } 
    $i++; 
} while ($data = fgetcsv($handle,1000,",","'")); 
//close the file stream                    
fclose($handle);

//delete the temp file
unlink($file);

//creates the meetings
foreach($times as $time){
    $booking->createMeetings($time);
}

//redirect to success screen
Session::flash('meeting','Meeting Invites sent successfully');
header("Location : http://tawazz.net/apointmate/organizer.php");

?>