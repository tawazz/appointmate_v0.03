<?php
    require_once("../classes/db.php");

    if(isset($_POST['AttId'])&& isset($_POST['bookingId'])){
        $attId =  $_POST['AttId'];
        $bookingId = $_POST['bookingId'];

        DB::connect()->insert("rejected",array(
            "AttendeeId"=> $attId,
            "bookingId"=> $bookingId
        ))
        ?header("Location: ../meetings.php?BookingId={$bookingId}&AttId={$attId}")
        : die("error occured") ;
    }else{
        die("something went wrong");
    }

?>
