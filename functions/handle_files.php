<?php
    ob_start();
    session_start();
    chdir('../classes');
    require_once('File.php');
    require_once('input.php');
    require_once('Attendee.php');
    require_once('booking.php');
    require_once('Session.php');

    if(Input::exist()){
        $bookingName = Input::get('name');
        $duration= Input::get('duration');
        $location = Input::get('location');
        $message = Input::get('description');
        $id = Session::get('id');
        $booking = new Booking();
        try{
            $booking->createBooking(array(
                "OrganizerId"=>$id,
                "BookingName"=> $bookingName,
                "MeetingDuration"=>$duration,
                "Description"=>$message,
                "Location"=>$location
            ));
        }catch(Exception $e){
            $err = $e->getMessage();
            header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error={$err}");
        }

        $bookingId = $booking->getBookingId();

    }else{
        header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error=error no input detected");
        die("error no input detected");
    }

    $att = new Attendee();
    if(isset($_FILES['time'])){
    //get the csv file 
        $file = new File($_FILES['time']);
        $max_size=1024;

        $file->setAllowed(array('csv'));
        
        if($file->isAllowed()){
            if(!$file->error()){
                if($file->inSizeLimit($max_size)){
                    $handle = fopen($file->fileLoc(),"r"); 
     
                    //loop through the csv file
                    $i =0;
                    $count =0;
                    do { 
                        if ($i>1){
                            if(strlen($data[0])>0 &&strlen($data[1])>0 &&strlen($data[2])>0 &&strlen($data[3])>0) { 
                               $count++; 
                            } 
                        } 
                        $i++; 
                    } while ($data = fgetcsv($handle,1000,",","'")); 
                    echo $count;
                    fclose($handle);
                    $filename_new = uniqid('',TRUE).'.'.$file->getFileExt();
                    $file_destination = '../uploads/'.$filename_new;

                    if(move_uploaded_file($file->getFileTempName(),$file_destination)){
                         //redirect to step 2
                        header("Location: http://tawazz.net/apointmate/organizer.php?p=meeting&m=pick_times&duration=".$duration."&num=".$count."&bookingId=".$bookingId."&file=".$file_destination);
                    }
                }else{
                    $err="file ".$file->getFileName()." is bigger than max size";
                    header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error={$err}");
                }
            }else{
                $err="file ".$file->getFileName()." is corrupted";
                header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error={$err}");
            }
        }else{
            $err="file ".$file->getFileName()." not allowed";
             header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error={$err}");
        }
    }else{
        header("Location : http://tawazz.net/apointmate/organizer.php?p=meeting&m=setup&error=file not found");
    }
    
?>