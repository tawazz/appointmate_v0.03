<?php
include('../classes/db.php');
include('../classes/Attendee.php');


$bookingid = 49;

$attendee = new Attendee();
$f = array("FirstName" => "Aaron",
           "LastName" => "Deakin",
	   "email" => "aarondigital@gmail.com",
	   "bookingId" => $bookingid);

#print_r($f);
#$attendee->create($f);
$d = DB::connect();
//$d->query('select * from information_schema.columns where table_name = ?',array("attendee"));
//$d->query('select * from bookings b join attendees a where b.BookingId = a.BookingId',array());
$d->query('select * from Bookings',array());
print_r($d->result());


?>
