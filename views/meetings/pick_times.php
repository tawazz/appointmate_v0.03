<?php
    require_once('classes/input.php');

    if(Input::exist("get")){
        $duration = Input::get("duration");
        $num_of_meetings = Input::get("num");
        $bookingId = Input::get("bookingId");
        $file = Input::get("file");
    }
    
?>
	<div class="container">
		<div class="row">
			<div class="errpan" class="ui-state-error ui-corner-all alert alert-danger" style="padding: 0 .7em; display:none;">
				<p><span class="ui-icon ui-icon-alert " style="float: left; margin-right: .3em;"></span>
					<span class="glyphicon glyphicon-warning-sign"></span>
					<strong>ERROR:</strong>  <span id="inner_error">An error occurred</span>
				</p>
			</div>
			<div class="col-sm-5">
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#instruct" role="tab" data-toggle="tab">Instructions</a>
					</li>
					<li><a href="#meth1" role="tab" data-toggle="tab">Fill Week</a>
					</li>
					<li><a href="#meth2" role="tab" data-toggle="tab">Fill Days</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="instruct">
						<div class="row firstRow">
							<ol>
								<li>Fill Week adds one meeting at the same time across a required number days</li>
								<li>Fill Days adds several meetings on a given date</li>
							</ol>
						</div>
					</div>
					<div class="tab-pane" id="meth1">
						<form id="meetingForm" class="firstRow">
							<div class="row">
								<div class="form-group">
									<label class="col-sm-4 control-label">Meeting Date</label>
									<div class="col-sm-8">
										<div class="input-group date" id="datePicker">
											<input type="text" class="form-control" name="meeting" id="datePickerVal" />	<span class="input-group-addon">
													<span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div>	<span class="help-block">DD/MM/YYYY</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label class="col-sm-4 control-label">Duration in days</label>
									<div class="col-sm-8">
										<input id="daysSelector" type="number" data-slider-min="1" data-slider-max="30" data-slider-step="1" data-slider-value="1" />	<span id="daysSelectorCurrentSliderValLabel"><span id="daysSelectorSliderVal">&nbsp;&nbsp;1 day(s)</span></span>
										<button id="daysSelectButton" class="btn btn-info btnBtmSpace">Type Number of Days</button>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group has-feedback ">
									<label class="col-sm-4 control-label">Start Time</label>
									<div class="col-sm-8">
										<div class='input-group date' id='startTimePicker'>
											<input type='text' class="form-control" id="startTimeVal" name="startTime" /> <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span>
											</span>
										</div> <span class="help-block">24 Hour format time</span>
									</div>
								</div>
							</div>
						</form>
						<div id="controls" class="row ">
							<button id="suggest_weekfill" class="btn btn-primary">Add to calendar</button>
						</div>
					</div>
					<div class="tab-pane" id="meth2">
						<form id="theForm" method="POST" action="organizer.php?p=meeting&m=confirm" class="firstRow">
							<div class="row">
								<div class="form-group has-feedback">
									<label class="col-sm-4 control-label">Start Date</label>
									<div class="col-sm-8">
										<div class="input-group date" id="dayStartDatePicker">
											<input type="text" id="startdate" class="form-control" name="startdate" /> <span class="input-group-addon">
													    <span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div> <span class="help-block">DD/MM/YYYY</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group has-feedback">
									<label class="col-sm-4 control-label">End Date</label>
									<div class="col-sm-8">
										<div class="input-group date" id="dayEndDatePicker">
											<input type="text" id="enddate" class="form-control" name="enddate" /> <span class="input-group-addon">
													    <span class="glyphicon glyphicon-calendar"></span>
											</span>
										</div> <span class="help-block">DD/MM/YYYY</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label for="workinghours" class="col-sm-4 control-label">Working hours</label>
									<div class="col-sm-8">
										<input type="text" id="workinghours" readonly="true" style="border:0; color:#f6931f; font-weight:bold;">
										<div id="workinghours-slider"></div> <span class="help-block">Working Hours: Start - End</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label for="lunch" class="col-sm-4 control-label">Lunch hours</label>
									<div class="col-sm-8">
										<input type="text" id="lunch" readonly="true" style="border:0; color:#f6931f; font-weight:bold;">
										<div id="lunch-slider"></div> <span class="help-block">Lunch Hours: Start - End</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<label for="gap" class="col-sm-4 control-label">Gap (mins)</label>
									<div class="col-sm-8">
										<input type="number" id="gap" value="5" class="form-control" /> <span class="help-block">Gap between meetings</span>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="form-group">
									<input type="hidden" id="duration" name="duration" value="<?php echo $duration;?>" />
									<label class="col-sm-4 control-label">Number of meetings</label>
									<div class="col-sm-8">
										<input type="number" class="form-control" id="num_of_meetings" name="num_of_meetings" value="<?php echo $num_of_meetings;?>" /> <span class="help-block">Total number meetings</span>
									</div>
								</div>
							</div>
							<div id="addSlots" class="row">
								<button id="addUnavSlot" class="btn">Block out time</button>
							</div>
						</form>
						<div class="row">
							<button id="suggest" class="btn btn-primary btnSpace">Add to Calendar</button>
						</div>
						<div class="row">
							<form id="eventValForm" action="organizer.php?p=meeting&m=confirm" method="post">
                                <button id="btn_next" class="btn btnSpace">Next ></button>
								<div class="row" id="calVals"></div><!--this is where the hidden inputs will show-->
                                <input type="hidden" name="bookingId" value="<?php echo $bookingId;?>"/>
                                <input type="hidden" name="file" value="<?php echo $file;?>"/>
							</form>
						</div>
					</div>
				</div>
				<!-- End tabs -->
			</div>
			<div class="col-sm-7 topSpace">
				<div id="suggested_times" class="toCal">
					<div id="cal"></div>
					<ul id="meetinglist"></ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Container -->

	<!-- Custom JS -->
	<script type="text/javascript">
     $(document).ready(function ()
     {
         $("head").append('<link href="css/meetingStep2.css" rel="stylesheet">');//adding the css only to this page
         $('#startTimePicker').datetimepicker({ //start time picker
             pickDate: false,
             format: 'HH:mm'
         });
         $('#endTimePicker').datetimepicker({ //end time picker
             pickDate: false,
             format: 'HH:mm'
         });
         $('#datePicker').datetimepicker( //date picker
             {
             pickTime: false,
             format: 'DD/MM/YYYY'
         });
         $('#dayEndDatePicker').datetimepicker( //date picker
             {
             pickTime: false,
             format: 'DD/MM/YYYY'
         });
         $('#dayStartDatePicker').datetimepicker( //date picker
             {
             pickTime: false,
             format: 'DD/MM/YYYY'
         });
         $('#meetingForm').bootstrapValidator({
             feedbackIcons: {
                 valid: 'glyphicon glyphicon-ok',
                 invalid: 'glyphicon glyphicon-remove',
                 validating: 'glyphicon glyphicon-refresh'
             },
             fields: {
                 meeting: {
                     validators: {
                         notEmpty: {
                             message: 'Please enter a date'
                         },
                         date: {
                             format: 'DD/MM/YYYY',
                             message: 'The value is not a valid date'
                         }
                     }
                 },
                 startTime: {
                     validators: {
                         date: {
                             format: 'HH:mm',
                             message: 'invalid time'
                         }
                     }
                 }
             }
         });
         $('#datePicker').on('dp.change dp.show', function (e) // Validate the date of fill week when user changes it
         {
             $('#meetingForm').bootstrapValidator('revalidateField', 'meeting');
         });
         $('#theForm').bootstrapValidator({
             feedbackIcons: {
                 valid: 'glyphicon glyphicon-ok',
                 invalid: 'glyphicon glyphicon-remove',
                 validating: 'glyphicon glyphicon-refresh'
             },
             fields: {
                 startdate: {
                     validators: {
                         notEmpty: {
                             message: 'Please enter a date'
                         },
                         date: {
                             format: 'DD/MM/YYYY',
                             message: 'The value is not a valid date'
                         }
                     }
                 },
                 enddate: {
                     validators: {
                         notEmpty: {
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
         $('#dayStartDatePicker').on('dp.change dp.show', function (e) // Validate the date when user change it
         {
             $('#dayEndDatePicker').data("DateTimePicker").setMinDate(e.date);
             $('#theForm').bootstrapValidator('revalidateField', 'startdate');
             $('#theForm').bootstrapValidator('revalidateField', 'enddate');
         });
         $('#dayEndDatePicker').on('dp.change dp.show', function (e) // Validate the date when user change it
         {
             $('#theForm').bootstrapValidator('revalidateField', 'enddate');
             $('#theForm').bootstrapValidator('revalidateField', 'startdate');
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
         });
         $('#addUnavSlot').click(function ()
         {
             /*var numOfBreaks=$('#calVals').children('.row').length;
             $("#addSlots").prepend(
             '<div class="row">'+
             '<div class="form-group">'+
             '   <label class="col-sm-4 control-label">break hours</label>'+
             '   <div class="col-sm-8">'+
             '       <input type="text" id="break'+numOfBreaks+'" readonly="true" style="border:0; color:#f6931f; font-weight:bold;">'+
             '       <div id="break'+numOfBreaks+'-slider"></div> <span class="help-block">break Hours: Start - End</span>'+
             '   </div>'+
             '</div>'+
             '</div>');

             ///break slider
             $("Script").append('
             $("#break"+numOfBreaks+"-slider").slider({
             range: true,
             min: 630,
             max: 960,
             value: [790, 810],
             step: 15,
             tooltip: 'hide'
             }).on('slide', function(event) {
             var txt_range = niceTimeRange($(this).slider('getValue')[0], $(this).slider('getValue')[1]);
             $("#break"+numOfBreaks).val(txt_range);
             });
             var whrs_range = $("#break"+numOfBreaks+"-slider").slider('getValue');
             $("#break"+numOfBreaks).val(niceTimeRange(whrs_range[0], whrs_range[1]));*/

         });
         // end .ready function
         /** Aaron's code **/
         function goNext()
         {
             generateRequest();
             $("#eventValForm").submit();
         }
         // Working hours slider
         $("#workinghours-slider").slider({
             range: true,
             min: 0,
             max: 1440,
             value: [555, 1020],
             step: 15,
             tooltip: 'hide'
         }).on('slide', function (event)
         {
             var txt_range = niceTimeRange($(this).slider('getValue')[0], $(this).slider('getValue')[1]);
             $("#workinghours").val(txt_range);
         });
         var whrs_range = $("#workinghours-slider").slider('getValue');
         $("#workinghours").val(niceTimeRange(whrs_range[0], whrs_range[1]));
         // Lunch break slider
         $("#lunch-slider").slider({
             range: true,
             min: 630,
             max: 960,
             value: [710, 750],
             step: 15,
             tooltip: 'hide'
         }).on('slide', function (event)
         {
             var txt_range = niceTimeRange($(this).slider('getValue')[0], $(this).slider('getValue')[1]);
             $("#lunch").val(txt_range);
         });
         var whrs_range = $("#lunch-slider").slider('getValue');
         $("#lunch").val(niceTimeRange(whrs_range[0], whrs_range[1]));

         // Buttons and small UI
         $("#suggest").click(function ()
         {
             fillMeetingDisplay("fill");
         });
         $("#suggest_weekfill").click(function ()
         {
             fillMeetingDisplay("week");
         });
         $("#btn_next").on('click', function ()
         {
             goNext();
         });
         $("#cal").fullCalendar({
             defaultView: 'agendaWeek',
             header: {
                 left: 'prev,next today',
                 center: 'title',
                 right: 'month,agendaWeek,basicDay',
                 ignoreTimezone: false
             },
             columnFormat: {
                 week: 'ddd D/M'
             },
             titleFormat: {
                 week: 'D MMM YYYY',
                 day: 'D MMMM YYYY'
             }
         });
     });
     /** end aarons code **/
	</script>