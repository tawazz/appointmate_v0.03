//tawanda nyakudjga
//calendar week view rendering script
//last update 06/08/2014

var weekDays = new Array("Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat");
var view = document.getElementsByClassName('calview');
var curmonth = document.getElementsByClassName('currMonth');
var html = "";
var TD = new Date();
var wd = TD.getDay();
var day = TD.getDate();
var month = TD.getMonth();
var year = TD.getFullYear();
var ds = new Date(year,month,day);
curmonth[0].innerHTML = "<h2 class='center'>" + getMonth(ds) + "</h2>";
writeCalView()
view[0].innerHTML = html;

document.getElementById("prev").onclick = function () {
    prevWk();
};
document.getElementById("next").onclick = function () {
    nextWk();
};
function add(name, ds, duration){

    var D = new Date(ds);
    
}
function nextWk(){
    for(var i=7;i>=0;i--){
        if(wd == i){
            console.log("wd is now : "+wd);
            console.log("the day is "+day);
            console.log("i is "+i);
            day = day+(7-i);
        }
    }
    ds = new Date(year,month,day);
    wd = ds.getDay();
    console.log(wd);
    console.log(day);
    curmonth[0].innerHTML = "<h2 class='center'>" + getMonth(ds) + "</h2>";
    writeCalView()
    view[0].innerHTML = html;
}
function prevWk(){
    for(var i=7;i>=0;i--){
        if(wd == i){
            console.log("wd is now : "+wd);
            console.log("the day is "+day);
            console.log("i is "+i);
            day = day-(i+1);
        }
    }
    ds = new Date(year,month,day);
    wd = ds.getDay();
    curmonth[0].innerHTML = "<h2 class='center'>" + getMonth(ds) + "</h2>";
    writeCalView()
    view[0].innerHTML = html;

}
function writeCalView(){
    html = "";
    for (var i=0;i< 7;i++){
    html += "<div class='day'>";
    for (var g = 1; g <= 25; g++)
        if (g == 1) {
            if (i == new Date(ds).getDay()) {
                html += "<div class = 'grid'><p class='red'>" + weekDays[i]  + "</p><span class ='num red'>" + daysInWeek(new Date(ds))[i] + "</span></div>";
            } else {
                html += "<div class = 'grid'><p>" + weekDays[i] + "</p><span class ='num'>" + daysInWeek(new Date(ds))[i] + "</span></div>";
            }
        } else {
            if(i == 0)
                html += "<div class ='grid' id='"+weekDays[i]  + g +"'><span class='inline'>"+(g-2)+":00</span></div>";
            else
                html += "<div class = 'grid' id='"+weekDays[i]  + g +"'></div>";
        }

    html += "</div>";
    
    } 
}