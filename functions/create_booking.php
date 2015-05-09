<?php
 ob_start();
    session_start();
    chdir('../classes');
    require_once('input.php');
    require_once('booking.php');
    require_once('Session.php');

    //check if data has been sent
    if(Input::exist()){
        //set up variables from query
        $bookingName = Input::get('name');
        $duration= Input::get('duration');
        $location = Input::get('location');
        $message = Input::get('description');
        $id = Session::get('id');
        
        //new booking object
        $booking = new Booking();

        //create the booking
        try{
            $booking->createBooking(array(
                "OrganizerId"=>$id,
                "BookingName"=> $bookingName,
                "MeetingDuration"=>$duration,
                "Description"=>$message,
                "Location"=>$location
            ));
        }catch(Exception $e){
            die($e->getMessage());
        }
        //get the created booking id
        $bookingId = $booking->getBookingId();

        //redirect to step 2
        header("Location: http://tawazz.net/apointmate/organizer.php?p=meeting&m=pick_times&duration=".$duration."&num=".$i."&bookingId=".$bookingId);

    }else{
        header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup");
        die("error no input detected");
    }

?>
