/*
* To do list
* adding blocktimes
*/

function niceTimeRange(startminutes, endminutes)//making minutes into hours and minutes
{
    var starthours = Math.floor(startminutes / 60);
    var startmins = startminutes - (starthours * 60);
    var endhours = Math.floor(endminutes / 60);
    var endmins = endminutes - (endhours * 60);
    //console.log(startmins);
    if (startmins.toString().length == 1) startmins = '0' + startminutes;
    if (starthours.toString().length == 1) starthours = '0' + starthours;
    if (endmins.toString().length == 1) endmins = '0' + endmins;
    if (endhours.toString().length == 1) endhours = '0' + endhours;
    return starthours + ":" + startmins + "-" + endhours + ":" + endmins;
}

function addSlot() {
    
}

function meeting(start, end, title, colour)//meeting constructor
{
    this.start = start;
    this.end = end;
    this.title = title;
    this.colour = colour;
}
function isInEventsCal(newStartDateTime,newEndDateTime)//checking if an event is in the calendar
{
    var events = $("#cal").fullCalendar('clientEvents');

    for (var i = 0; i < events.length; i++)
    {
        //preventing overlapping events
        if(!(events[i].start.toDate() >= newEndDateTime || events[i].end.toDate() <= newStartDateTime))
        {
            return true;
        }
    }
    return false;
}
function suggest_week_meth()//method to fill one meeting time over many days
{
    var num_days = $("#daysSelector").val();
    var startDT = moment($("#datePickerVal").val() + " " + $("#startTimeVal").val(), 'DD/MM/YYYY HH:mm');

    var meetings = Array();

    var duration = 30;

    var curDT = startDT;
    for (var i = 0; i < num_days; i++)
    {
        startdate = curDT.clone();
        enddate = curDT.clone();
        enddate.add(duration, 'minutes');
        var m = new meeting(startdate.toDate(), enddate.toDate(), 'Meeting ' + i, 'blue');
        if (!isInEventsCal(m.start,m.end))//add event only if it does not overlap with any other times
        {
            meetings.push(m);
        }
        else
        {
            var errpan = $("#errpan");
            $("#inner_error").html("Not all times could be scheduled! Meeting slot unavailable");
            errpan.show("fade");
        }
        curDT.add(1, 'days');
    }
    var events = $("#cal").fullCalendar('clientEvents');
    
    return meetings;
}

function suggest_fill_meth()//method to fill multiple meeting times
{
    var startdate = Date.parse(moment($("#startdate").val(), 'DD/MM/YYYY').toDate());
    var starttime = $("#workinghours-slider").slider('getValue')[0];
    var startDT = addMins(startdate, starttime);
    var endtime = $("#workinghours-slider").slider('getValue')[1];
    var enddate = Date.parse(moment($("#enddate").val(), 'DD/MM/YYYY').toDate()); // temp doing just for one day
    var endDT = addMins(enddate, endtime);
    var lunchstarttime = $("#lunch-slider").slider('getValue')[0];
    var lunchendtime = $("#lunch-slider").slider('getValue')[1];

    var sd = moment(moment($("#startdate").val(), 'DD/MM/YYYY').toDate());
    var ed = moment(moment($("#enddate").val(), 'DD/MM/YYYY').toDate());
    var totalDays = (ed.diff(sd, 'days')) + 1;
    //alert(totalDays);
    var duration = parseInt($("#duration").val());
    var gap = parseInt($("#gap").val());
    var numMeetings = parseInt($("#num_of_meetings").val());

    // Reset things
    var meetings = Array();

    var morning_mins = startdate + lunchstarttime - startDT;

    var curDT = startDT;
    var curDayEndTime = addMins(startdate, endtime);
    //alert(curDayEndTime);
    for (var i = 0; i < numMeetings; i++)
    {
        if (newendtime >= curDayEndTime)//go to next day start of day
        {
            var curStartofDay = getStartOfDay(curDT); //start of current calc day
            var nextDayStart = addMins(curStartofDay, 1440); //start of next calc day
            //console.log('nextStartDay ' + nextDayStart);
            curDT = addMins(nextDayStart, starttime); //change start dateTime to next day
            //console.log(curDT+"asdfasdfadsfasf");
            curDayEndTime = addMins(curDayEndTime, 1440); //change curDayEndTime to next day
        }
        //add if to check end of day and skip to next
        if (addMins(curDT, duration) > endDT)
        {
            var errpan = $("#errpan");
            $("#inner_error").html("Not all times could be scheduled!");
            errpan.show("fade");
            break;
        }
        //console.log(curDT + "some");
        var newendtime = addMins(curDT, duration);
        var lunchstart = addMins(getStartOfDay(curDT), lunchstarttime);
        var lunchend = addMins(getStartOfDay(curDT), lunchendtime);

        if (newendtime > lunchstart && curDT <= lunchstart)
        {
            curDT = lunchend;
        }
        //console.log(newendtime);
        var m = new meeting(curDT, addMins(curDT, duration), "Meeting " + i, "blue");
        if(!isInEventsCal(m.start,m.end))//only add meeting if times do not overlap
        {
            meetings.push(m);
        }
        else
        {
            var errpan = $("#errpan");
            $("#inner_error").html("Not all times could be scheduled! Meeting slot unavailable");
            errpan.show("fade");
        } 
        curDT = addMins(curDT, duration + gap);
    }

    return meetings;
}

function addMins(oldDate, mins)//adding minutes to a time
{
    return new Date(new Date(oldDate).getTime() + mins * 60000);
}

function getStartOfDay(dt)//getting start time of a date
{
    return new Date(dt.getFullYear(), dt.getMonth(), dt.getDate());
}

function fillMeetingDisplay(meth)//adding the meetings to the calendar
{
    $("#errpan").hide();

    if (meth == "fill")
        meetings = suggest_fill_meth();
    else
        meetings = suggest_week_meth();

    calcol = []

    for (var i = 0; i < meetings.length; i++)
    {
        calcol.push({ title: meetings[i].title,
            start: meetings[i].start,
            end: meetings[i].end,
            durationEditable: false,
            editable: false,
            startEditable: true,
            backgroundColor: meetings[i].colour,
            id: "meeting_" + i
        });
       //console.log(meetings[i].colour);
    };
    $("#cal").fullCalendar('addEventSource', calcol);
}

function generateRequest()//when next is clicked this function is called to create event start times
{
    var events = $("#cal").fullCalendar('clientEvents');
    //console.log(events.length);
    for (var i = 0; i < events.length; i++)
    {
        //console.log($('#calVals').children().length);
        if(($('#calVals').children().length)<events.length)//if next button pressed many times, only append div once
        {
            $("#calVals").append("<input type='hidden' name='times[]' id='" + moment(events[i].start).format("YYYY-MM-DD HH:mm:ss")+ "'" +
			             " value='" + moment(events[i].start).format("YYYY-MM-DD HH:mm:ss") + "' />\n");
        }
        
        
    }
}
