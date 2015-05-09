//tawanda nyakudjga
//javascript calender date functions
//last update 06/08/2014

function getWholeDate(ds)
{
    var D = new Date(ds);
    var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    var month = D.getMonth();
    var day = D.getDate();
    var year = D.getFullYear();
    var wd = D.getDay();
    var weekDays = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");

    return (weekDays[wd] +" " +day + "/" + months[month] + "/" + year);
}

function getMonth(ds) {
    var D = new Date(ds);
    var months = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    return months[D.getMonth()];
}

function getWeekDay(ds){

    var D = new Date(ds);
    var wd = D.getDay();
    var weekDays = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
    return (weekDays[wd]);
}

function daysInWeek(ds){
    var D = new Date(ds);
    var wd = D.getDay();
    var day = D.getDate();
    var month = D.getMonth();
    var year = D.getFullYear();
    var weekdays = new Array();
    var lastday = new Date(year,month+1,0).getDate();

    switch(wd){
        case 0:
            for (var i = 0; i < 7; i++) {
                if(day+i <= lastday)
                weekdays.push(day + i);
                else{
                    weekdays.push(" ");
                }
            }
            break;
        case 1:
            for (var i = 0; i < 7; i++) {
                if (i >= 1) {
                    if( (day + (i - 1)) <= lastday){
                        weekdays.push(day + (i - 1));
                    }else{
                        weekdays.push(" ");
                    }
                } else if ((day -1) <= 0 ){
                    weekdays.push(" ");
                } else {
                    weekdays.push(day - 1);
                }
            }
            break;
        case 2:
            var y = 2;
            for (var i = 0; i < 7; i++) {
                if (i >= 2){
                    if((day + (i-2)) <= lastday){
                        weekdays.push(day + (i - 2));
                    }else{
                        weekdays.push(" ");
                    }
                }else if ((day - 2) < 0 ) {
                    weekdays.push(" ");
                } else {
                    weekdays.push(day - y);
                    y -= 1;
                }
            }
            break;
        case 3: 
            var y = 3;
            for (var i = 0; i < 7; i++) {
                if (i >= 3){
                    if((day + (i-3)) <= lastday){
                        weekdays.push(day + (i - 3));
                    }else{
                        weekdays.push(" ");
                    }
                    
                }else if ((day - 3) < 0) {
                    weekdays.push(" ");
                } else {
                    weekdays.push(day - y);
                    y -= 1;
                }
            }
        break;
    case 4:
        var y = 4;
        for (var i = 0; i < 7; i++) {
            if (i >= 4) {
                if ((day + (i - 4)) <= lastday) {
                    weekdays.push(day + (i - 4));
                }else{
                    weekdays.push(" ");
                }
            } else if ((day - y) <= 0) {
                weekdays.push(" ");
            } else {
                weekdays.push(day - y);
                y -= 1;
            }
        }
        break;
    case 5:
        var y = 5;
        for (var i = 0; i < 7; i++) {
            if (i >= 5) {
                if ((day + (i - 5)) <= lastday) {
                    weekdays.push(day + (i - 5));
                }else{
                    weekdays.push(" ");
                }
            } else if ((day - 5) < 0) {
                weekdays.push(" ");
            } else {
                weekdays.push(day - y);
                y -= 1;
            }
        }

        break;
    case 6:
        var y = 6;
        for (var i = 0; i < 7; i++) {
            if (i >= 6) {
                if ((day + (i - 6)) <= lastday) {
                    weekdays.push(day + (i - 6));
                }else{
                    weekdays.push(" ");
                }
            } else if ((day - 6) < 0 ) {
                weekdays.push(" ");
            } else {
                weekdays.push(day - y);
                y -= 1;
            }
        }
        break;
        default :
    }

    return weekdays;
}

