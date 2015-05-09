<!DOCTYPE html>
<html>
	<head>
		<!-- Website Title & Description for Search Engine purposes -->
		<title>Time Pick</title>
		<meta name="description" content="">
		<!-- Mobile viewport optimized -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<!-- Bootstrap CSS -->
		<link href="../../css/bootstrap.css" rel="stylesheet">
		<link href="../../css/bootstrap.min.css" rel="stylesheet">
		<link href="../../css/bootstrap-glyphicons.css" rel="stylesheet">
		<link href="../../css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		<link href="../../css/bootstrap-datetimepicker.css" rel="stylesheet">
		<link href="../../css/bootstrapValidator.css" rel="stylesheet">
		<link href="../../css/bootstrapValidator.min.css" rel="stylesheet">
		<link href="../../css/bootstrap-slider.css" rel="stylesheet">
		<!-- Custom CSS -->
		<link href="../../css/styles.css" rel="stylesheet">
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="../../js/modernizr-2.6.2.min.js"></script>
		<style type="text/css">
			/* Override feedback icon position */
			.form-horizontal .has-feedback .form-control-feedback {
			right:  50px;
			}
		</style>
	</head>
	<body>
		<div class="navbar navbar-default navbar-fixed-top" role="navigation" >
			<div class="container">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Apointmate</a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<ul class="nav navbar-nav">
						</ul>
						<!--right nav bar-->
						<ul class="nav navbar-nav navbar-right">
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <span class="caret"></span></a>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">View Account</a></li>
									<li><a href="#">Change Password</a></li>
									<li class="divider"></li>
									<li><a href="functions/logout.php">Logout</a></li>
								</ul>
							</li>
						</ul>
					</div>
					<!-- /.navbar-collapse -->
				</div>
				<!-- /.container-fluid -->
			</div>
			<!--end navbar-->
		</div>
		<div id="_calendar">
			<div class="container">
				<h1>Meeting Time Selection </h1>
				<br />
				<div class="row">
					<form id="meetingForm" class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label">Meeting Date</label>
							<div class="col-sm-1">
								<div class="input-group date" id="datePicker">
									<input type="text" class="form-control" name="meeting" />
									<span class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
									</span>
								</div>
								<span class="help-block">DD/MM/YYYY</span>
							</div>
						</div>
					</form>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2 control-label">Duration in days</label>
						<div class="col-sm-5">
							<input id="daysSelector" type="number" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1"/>
							<span id="daysSelectorCurrentSliderValLabel"><span id="daysSelectorSliderVal">1 day(s)</span></span>
							<button id="daysSelectButton">Input Number of Days</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group">
						<label class="col-sm-2 control-label">Start Time</label>
						<div class="col-sm-3">
							<div class='input-group date' id='startTimePicker'>
								<input type='text' class="form-control" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
						<label class="col-sm-2 control-label">End Time</label>
						<div class="col-sm-3">
							<div class='input-group date' id='endTimePicker'>
								<input type='text' class="form-control" />
								<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- All Javascript at the bottom of the page for faster page loading -->
		<!-- First try for the online version of jQuery-->
		<script src="http://code.jquery.com/jquery.js"></script>
		<!-- If no online access, fallback to our hardcoded version of jQuery -->
		<script>window.jQuery || document.write('<script src="../../js/jquery.js"><\/script>')</script>
		<!-- Bootstrap JS -->
		<script src="../../js/bootstrap.js"></script>
		<script src="../../js/bootstrap.min.js"></script>
		<script src="../../js/moment.js"></script>
		<script src="../../js/bootstrap-datetimepicker.min.js"></script>
		<script src="../../js/bootstrap-datetimepicker.js"></script>
		<script src="../../js/bootstrapValidator.min.js"></script>
		<script src="../../js/bootstrapValidator.js"></script>
		<script src="../../js/bootstrap-slider.js"></script>
		<!-- Custom JS -->
		<script type="text/javascript">
			$(document).ready(function ()
			{
			    $('#startTimePicker').datetimepicker({//start time picker
                    pickDate: false,
                    format: 'HH:mm'
			          });
                $('#endTimePicker').datetimepicker({//end time picker
                    pickDate: false,
                    format: 'HH:mm'
			          });
			    $('#datePicker').datetimepicker(//date picker
			    {
			        pickTime: false,
			        format: 'DD/MM/YYYY'
			    });
			
			    $('#meetingForm').bootstrapValidator({//validation of date
			        feedbackIcons: {
			            valid: 'glyphicon glyphicon-ok',
			            invalid: 'glyphicon glyphicon-remove',
			            validating: 'glyphicon glyphicon-refresh'
			        },
			        fields: {
			            meeting: {
			                validators: {
			                    notEmpty:
			                    {
			                        message: 'Please enter a date'
			                    },
			                    date: {
			                        format: 'DD/MM/YYYY',
			                        message: 'The value is not a valid date'
			                    }
			                }
			            }
			        }
			    });
			
			    $('#datePicker').on('dp.change dp.show', function (e)
			        {
			            // Validate the date when user change it
			            $('#meetingForm').bootstrapValidator('revalidateField', 'meeting');
			        });
			    
			    //slider code
			    $("#daysSelector").slider();
			    $("#daysSelector").on("slide", function (slideEvt)
			    {
			        $("#daysSelectorCurrentSliderValLabel").html("&nbsp;&nbsp;" + slideEvt.value + " day(s)");
			    });
			    $("#daysSelectButton").click(function ()
			    {
			        $("#daysSelector").slider('destroy');
			        $("#daysSelectorCurrentSliderValLabel").text("");
			        $("#daysSelectButton").attr('id', 'daysSlideButton');
			    });
			});
		</script>
	</body>
</html>