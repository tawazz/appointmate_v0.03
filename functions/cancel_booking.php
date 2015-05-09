<?php
session_start();
require_once("../classes/db.php");
require_once("../classes/Session.php");

    if(isset($_POST['bookingId'])){
        //create booking object from booking id
        $bookingId = $_POST['bookingId'];
        if(isset($_POST['file'])){
            //gets the temperal csv file
            $file = $_POST['file'];
        }else{
           die("file not set"); 
        }
    }else{
        die("booking id not set");
    }

    DB::connect()->delete("booking",array("BookingId","=",$bookingId));
    unlink($file);
    Session::flash('meeting','Booking was canceled, No invites where sent');
    header("Location : http://tawazz.net/apointmate/organizer.php");

?>