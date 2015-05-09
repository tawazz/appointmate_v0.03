<?php
    require_once('classes/db.php');
    require_once('classes/booking.php');
    require_once("classes/Attendee.php");
    require_once('classes/Session.php');

    /*<?php echo (active('login','p'))? "class='active'" : "";?>>*/
    $q = DB::connect()->query("select * from booking where OrganizerId = ? order by CreatedTS limit 20",array($id));
    $bookings = $q->result();
?>
<div class="modal fade" id="files_handler">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Meeting minutes</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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
				      "<br/><button class=\"btn addfilebtn\" id=\"add_meeting_".$meeting->MeetingId."\">Add file</button>".
                                    "<button class=\"btn filebtn\" id=\"view_meeting_".$meeting->MeetingId."\">View meeting file</button>".
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
<script>
		 function checkForComplete() {
		   id = $("#meetingId").val();
		   if ($("#upload_target").contents().find("#result").html()) {
                     if ($("#upload_target").contents().find("#result").html() == "File uploaded.") {
		       //               $("#files_handler").modal('hide');
                       showFiles(id)
		     }
		   } else { 
                     setTimeout(checkForComplete,1);
		   }
		 };

function showFiles(id) {
    $("#files_handler .modal-body").load("functions/view_files.php?meetingId="+id); 
    $("#files_handler").modal('show');
}

  $(".filebtn").click(function() {
    id = $(this).attr("id").split('_')[2];
    showFiles(id);
  });
  $(".addfilebtn").click(function() {
    id = $(this).attr("id").split('_')[2];
    newhtml = '<form id="fupload" action="functions/upload_minutes.php" method="post" enctype="multipart/form-data" target="upload_target"><input type="hidden" id="meetingId" name="meetingId" value="'+id+'" /><input name="userfile" id="userfile" type="file" /><button class="btn btn-active" id="addfile">Add</button></form><iframe id="upload_target" name="upload_target" src="#" style="width:100%;height:40px;border:0px solid #fff;"></iframe>';

    $("#files_handler .modal-body").html(newhtml);
    $("#addfile").click(function() { 
	$("#fupload").submit();
        setTimeout(checkForComplete, 1);
        return false; });
    $("#files_handler").modal('show');
  });
    
</script>