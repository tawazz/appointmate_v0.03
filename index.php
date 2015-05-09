<?php
session_start();
require_once('classes/Session.php');
    if(isset($_GET['p'])){
        $page = $_GET['p'];
    }else{
        $page="login";
    }

    function active($str, $p =''){
         if(isset($_GET[$p])){
             $p = $_GET[$p];
         }else{
            $p = 'login';
         }
        return $p == $str ? true : false;
    }

?>
<!DOCTYPE html>

<html>
	<head>
		
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Appointmate</title>
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
                    <li <?php echo (active('login','p'))? "class='active'" : "";?>><a href="index.php">Home</a></li>
                    <li <?php echo (active('register','p'))? "class='active'" : "";?>><a href="index.php?p=register">Register</a></li>
                    <li><a href="admin/">Admin</a></li>
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
                  <h1 style="text-transform: capitalize"><?php echo $page;?></h1>
                </div>
	        </div><!-- end row -->
	        <div class="row">
                <?php
                    file_exists("views/".$page.".php") ? include("views/".$page.".php") : include("views/file_not_found.php");
                ?>
            </div><!-- end row -->
	

	
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