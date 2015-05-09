<?php
require_once("classes/db.php");
require_once("classes/booking.php");
require_once("classes/input.php");
require_once("classes/Attendee.php");
if(Input::exist("get")){

    if(isset($_GET["BookingId"]) && isset($_GET["AttId"]) ){
            $BookingId = $_GET["BookingId"];
            $AttId = $_GET["AttId"];

            $booking = new Booking($BookingId);
    }else{
        die("link expired");
    }
}else{
    die("link expired");
}

?>
<!DOCTYPE html>

<html>
	<head>
		
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Apointmate</title>
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-glyphicons.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link href="css/styles.css" rel="stylesheet">
		
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="js/modernizr-2.6.2.min.js"></script>
		
	</head>
	<body>
	    <div class="container" id="main">
	        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
              <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
                  <a class="navbar-brand" href="index.php">Apointmate</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="index.php">Meetings</a></li>
                  </ul>
                    <!--right nav bar-->
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">About Us <span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Help</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav><!--end navbar-->
	
	        <div class="row" id="pageHeader">
                <div class="page-header txt-center">
                  <h1 style="text-transform: capitalize">Pick Meeting</h1>
                </div>
	        </div><!-- end row -->
	        <div class="row">
                <?php
                    $att = new Attendee();
                    //check if meeting was rejected                    
                    $query = DB::connect()->query("select * from rejected where AttendeeId = ? AND bookingId = ?",array($AttId,$BookingId));
                    $result = $query->first();
                    if($query->count()){
                        echo  "<div class=\"col-md-4 col-sm-6\">";
                        echo  "<div class=\"panel panel-danger\">";
                        echo  "<div class=\"panel-heading text-capitalize\"><h4>{$att->getAttendee($AttId)},You have Rejected this Meeting</h4></div>";
   			            echo  "<div class=\"panel-body\">";
                        echo '<h2>You Rejected This Meeting </h2>';
                        echo   "</div></div></div>";
                        exit(0);
                    }
                    //check if meeting already accepted
                    $query = DB::connect()->query("select DATE_FORMAT(TimeStart,'%b-%d-%Y-%h:%i-%p')as Date ,MeetingId,AttendeeId from meeting where AttendeeId = ?",array($AttId));
                    $result = $query->first();
                    if($query->count()){
                        
                        echo  "<div class=\"col-md-4 col-sm-6\">";
                        echo  "<div class=\"panel panel-warning\">";
                        echo  "<div class=\"panel-heading text-capitalize\"><h4>{$att->getAttendee($result->AttendeeId)},You have this Meeting booked</h4></div>";
   			            echo  "<div class=\"panel-body\">";
                         foreach($booking->getMeetings() as $meeting){
                             if($meeting->MeetingId == $result->MeetingId){
                                 
                                 $date = explode('-',$result->Date);
                                  echo  "<div class=\"clearfix\"></div>";
                                  echo  "<ul class=\"list-group\">";
                                  echo  "<li class=\"list-group-item\">
                                                 Date
                                                <span class=\"label label-primary size15 pull-right text-capitalize\">{$date[1]} /{$date[0]} /{$date[2]}</span>
                                              </li>";
                                  echo  "<li class=\"list-group-item\">
                                                Time
                                                  <span class=\"label label-primary size15 pull-right text-capitalize\">{$date[3]} {$date[4]}</span>
                                              </li>";
                                  echo  "<li class=\"list-group-item\">
                                                Organizer
                                                  <span class=\"label label-primary size15 pull-right text-capitalize\">".$booking->getOrganizer()."</span>
                                              </li>";
                                  echo  "<li class=\"list-group-item\">
                                                Location
                                                  <span class=\"label label-primary size15 pull-right text-capitalize\">".$booking->getLocation()."</span>
                                              </li>";
                                 echo  "<li class=\"list-group-item\"><h4>Description</h4>
                                                  <p>".$booking->getDescription()."</p>
                                              </li>
                                            </ul>";
                             }else{
                             }
                         }
                        echo   "</div></div></div>";
                        exit(0);
                    }                       

                    if(!$booking->numOfMeetings(FALSE)){
                        
                        echo  "<div class=\"col-md-4 col-sm-6\">";
                        echo  "<div class=\"panel panel-danger\">";
                        echo  "<div class=\"panel-heading text-capitalize\"><h4>ERROR!!!</h4></div>";
   			            echo  "<div class=\"panel-body\">";
                        echo '<h2>No Meetings Found !!!</h2>';
                        echo   "</div></div></div>";
                        exit(0);
                    }else{
                        foreach($booking->getMeetings(FALSE) as $meeting){
                          $date = explode('-',$meeting->Date);
                          echo  "<div class=\"col-md-4 col-sm-6\">";
                          echo  "<div class=\"panel panel-default\">";
                          echo  "<div class=\"panel-heading text-capitalize\"><h4>{$booking->name()}</h4></div>";
   			              echo  "<div class=\"panel-body\">";
                          echo  "<div class=\"clearfix\"></div>";
                          echo  "<ul class=\"list-group\">";
                          echo  "<li class=\"list-group-item\">
                                         Date
                                        <span class=\"label label-primary size15 pull-right text-capitalize\">{$date[1]} /{$date[0]} /{$date[2]}</span>
                                      </li>";
                          echo  "<li class=\"list-group-item\">
                                        Time
                                          <span class=\"label label-primary size15 pull-right text-capitalize\">{$date[3]} {$date[4]}</span>
                                      </li>";
                          echo  "<li class=\"list-group-item\">
                                        Organizer
                                          <span class=\"label label-primary size15 pull-right text-capitalize\">".$booking->getOrganizer()."</span>
                                      </li>";
                          echo  "<li class=\"list-group-item\">
                                        Location
                                          <span class=\"label label-primary size15 pull-right text-capitalize\">".$booking->getLocation()."</span>
                                      </li>";
                         echo  "<li class=\"list-group-item\"><h4>Description</h4>
                                          <p>".$booking->getDescription()."</p>
                                      </li>
                                    </ul>";
                         echo  "<div class=\"panel-footer col-xs-12\">
                                        <span class=\"space\"></span>
                                        <form method='post' action=\"functions/accept.php\">
                                        <input type=\"hidden\" name=\"AttId\" value=\"{$AttId}\"/>
                                        <input type=\"hidden\" name=\"meetingId\" value=\"{$meeting->MeetingId }\"/>
                                        <input type=\"hidden\" name=\"bookingId\" value=\"{$BookingId}\"/>
                                        <button type=\"submit\" class=\"btn btn-primary col-xs-12 \">Accept</button>
                                        </form>
                                    </div>
                                </div>
                             </div> 
	                    </div>";
                        }
                    }
                ?>
                   
            </div><!-- end row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="panel panel-default">
                      <div class="panel-body">
                            <div class="btn-toolbar" role="toolbar">
                                <div class="btn-group">
                                    <form method="post" action="functions/unable_to_attend.php">
                                        <input type="hidden" name="AttId" value="<?php echo $AttId;?>"/>
                                        <input type="hidden" name="bookingId" value="<?php echo $BookingId; ?>"/>
                                        <button type="submit" class="btn btn-warning col-xs-12">Unable To Attend</button>
                                    </form>
                                </div>
                                <div class="btn-group">
                                    <form method="post" action="functions/reject.php">
                                        <input type="hidden" name="AttId" value="<?php echo $AttId;?>"/>
                                        <input type="hidden" name="bookingId" value="<?php echo $BookingId; ?>"/>
                                        <input type="submit" class="btn btn-danger col-xs-12" value="Reject Meeting" />
                                    </form>
                                </div>
                            </div>
                      </div>
                    </div> 
                </div>
            </div>	

	
    </div><!-- end container -->
    

	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	<!-- First try for the online version of jQuery-->
	<script src="http://code.jquery.com/jquery.js"></script>
	
	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<script src="js/bootstrap.min.js"></script>
	
	<!-- Custom JS -->
	<script src="js/Script.js"></script>
	
	</body>
</html>