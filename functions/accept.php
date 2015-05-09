<?php
require_once("../classes/db.php");
require_once("../classes/Validate.php");
require_once("../classes/Attendee.php");
if(isset($_POST['AttId'])&& isset($_POST['meetingId'])&& isset($_POST['bookingId'])){
  $attId =  $_POST['AttId'];
  $meetingId =$_POST['meetingId'];
  $bookingId = $_POST['bookingId'];
  $val = new Validate();
  $meeting= array("AttendeeId"=> $attId); 

  $validation = $val->check($meeting,array(
    "AttendeeId" => array(
        'required'=> TRUE,
        'unique'=>'meeting'
    )
  ));

  if($validation -> passed()){
      DB::connect()->update("meeting",array("MeetingId","=",$meetingId),array("AttendeeId"=> $attId))?
       header("Location: ../meetings.php?BookingId={$bookingId}&AttId={$attId}"): die("error occured") ;
  }else{
      header("Location: ../meetings.php?BookingId={$bookingId}&AttId={$attId}");
  }
}else{
    die("An error occured.");
}

?>
