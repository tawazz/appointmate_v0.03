<?php
    require_once('classes/db.php');
    require_once('classes/booking.php');
    require_once("classes/Attendee.php");
    require_once('classes/Session.php');

    /*<?php echo (active('login','p'))? "class='active'" : "";?>>*/
    $q = DB::connect()->query("select * from booking where OrganizerId = ? order by CreatedTS limit 20",array($id));
    $bookings = $q->result();
?>
<div class="col-xs-12">
    <div class=" col-sm-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Previous Bookings</div>
                <div class="panel-body">
                   <div class="list-group">
                       <?php 
                            foreach($bookings as $booking){
                                echo (active($booking->BookingId,'booking'))? "<a href=\"organizer.php?p=calender&booking={$booking->BookingId}\" class=\"list-group-item active\">".$booking->BookingName."</a>" : "<a href=\"organizer.php?p=calender&booking={$booking->BookingId}\" class=\"list-group-item\">".$booking->BookingName."</a>";
                            }
                        ?>
                    </div>
                </div>
            </div>
    </div>
    <div class="col-sm-6 col-xs-12 ">
        <div class="panel panel-primary">
            <div class="panel-heading">Meetings</div>
                <div class="panel-body">
                    <?php
                        if(isset($_GET['booking'])){
                            $bk = $_GET['booking'];
                            $booking = new Booking($bk);
                            $meetings = $booking->getMeetings();
                            chdir("functions/");
                            $att = new Attendee();
                            echo "<div class=\"list-group\">";
                                foreach($meetings as $meeting){
                                    isset($meeting->AttendeeId)? $attendee = $att->getAttendee($meeting->AttendeeId) : $attendee = "Meeting not confirmed" ;
                                    echo "<li class='list-group-item'>"
                                    .$attendee.
                                    "<br/>" . 
                                    $meeting->Date.
                                    "<br/><a href='#'>Upload meeting file</a>".
                                    "<br/><a href='#'>View meeting file</a>".
                                    "</li>";
                                }
                            echo "</div>";
                        }else{
                            echo"<h3>No booking selected</h3>";
                        }
                    ?>
                 </div>
            </div>
    </div>
</div>