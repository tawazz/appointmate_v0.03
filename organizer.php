<?php
    session_start();
    require_once('classes/Session.php');
    require_once('classes/db.php');

    if(!Session::exists('id')){
        header("Location: index.php");
        exit(0);
    }
    $id = Session::get('id');
    $User= DB::connect()->get('users',array("id","=",$id));
    $fname = $User->first()->fname;
    $lname = $User->first()->lname;
    $p="";
    if(isset($_GET['p'])){
        $p = $_GET['p'];
    }else{
        $p = 'home';
    }

    function active($str, $p =''){
         if(isset($_GET[$p])){
             $p = $_GET[$p];
         }else{
            $p = 'home';
         }
        return $p == $str ? true : false;
    }


?>

<!DOCTYPE html>

<html>
	<head>
		
		<!-- Website Title & Description for Search Engine purposes -->
		<title><?php echo $p;?></title>
		<meta name="description" content="">
		
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-glyphicons.css" rel="stylesheet">
        <!--link href="css/bootstrap.css" rel="stylesheet"-->
		<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		<link href="css/bootstrap-datetimepicker.css" rel="stylesheet">
		<link href="css/bootstrapValidator.css" rel="stylesheet">
		<link href="css/bootstrapValidator.min.css" rel="stylesheet">
		<link href="css/bootstrap-slider.css" rel="stylesheet">
		<link href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="css/styles.css" rel="stylesheet">
		
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="js/modernizr-2.6.2.min.js"></script>
        <!-- First try for the online version of jQuery-->
	    <script src="http://code.jquery.com/jquery.js"></script>
	
	    <!-- If no online access, fallback to our hardcoded version of jQuery -->
	    <script>window.jQuery || document.write('<script src="js/jquery.js"><\/script>')</script>

        <style type="text/css">
			/* Override feedback icon position */
			.form-horizontal .has-feedback .form-control-feedback {
			right:  50px;
			}
		</style>
		
	</head>
	<body>
        <div class="container">
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
                  <a class="navbar-brand" href="organizer.php">Apointmate</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                  <ul class="nav navbar-nav">
                    <li <?php echo (active('home','p'))? "class='active'" : "";?>><a href="organizer.php">Home</a></li>
                    <li <?php echo (active('meeting','p')) ? "class='active'":"";?>><a href="organizer.php?p=meeting">Meetings</a></li>
                    <li <?php echo (active('calender','p'))? "class='active'":"";?>><a href="organizer.php?p=calender">Calendar</a></li>
                  </ul>
                    <!--right nav bar-->
                  <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="text-capitalize"><?php echo $fname ." ".$lname ;?> </span><span class="caret"></span></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="organizer.php?p=account">View Account</a></li>
                        <li><a href="#">Change Password</a></li>
                        <li class="divider"></li>
                        <li><a href="functions/logout.php">Logout</a></li>
                      </ul>
                    </li>
                  </ul>
                </div><!-- /.navbar-collapse -->
              </div><!-- /.container-fluid -->
            </nav><!--end navbar-->
        	    <div class="row first">
                    <?php
                        file_exists("views/".$p.".php") ? include("views/".$p.".php") : include("views/file_not_found.php");
                    ?>
	            </div><!-- end row -->
        </div>
    <footer>
    
    </footer><!--end footer-->

	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	
	
	<!-- Bootstrap JS -->
	<!--script src="js/bootstrap.min.js"></script--><!--Causing dropdown bug , needs more testing-->
    <script src="js/bootstrap.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/moment-timezone.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	<script src="js/bootstrap-datetimepicker.js"></script>
	<script src="js/bootstrapValidator.min.js"></script>
	<script src="js/bootstrapValidator.js"></script>
	<script src="js/bootstrap-slider.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.js"></script>
	
    <!-- Page specific login here -->
	<script src="js/suggest-engine.js"></script>
	<!-- Custom JS -->
	<script src="js/Script.js"></script>
	
	</body>
</html>