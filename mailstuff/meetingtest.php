<?php
include_once('../classes/booking_dev.php');

if (!isset($_GET['bid'])) 
  { $bid = 58; } else { $bid = $_GET['bid']; }

$b = new Booking($bid);
$attendees = $b->getAttendees();
echo "Attendee count: ".$b->numOfAttendees();
echo "<br />";
foreach ($attendees as $a)
print_r($a);

?>