<?php 
// Some basic setup for testing... should be configured in php.ini
ini_set('display_errors',1);  error_reporting(E_ALL);
ini_set('date.timezone','Australia/Perth');

// Using composer.phar for dependancies... again, however you want to install the SwiftMailer library 
require_once '../lib/autoload.php';

// Our iCalendar library
require_once 'ical.php';

# This array format is the expectation of Swift mailer
$to = array($_GET['toaddr'] => $_GET['toname']);
$from = array("app@ec2-54-206-61-227.ap-southeast-2.compute.amazonaws.com" => "AppointMate Mail Robot");
# Tuple of address and display name
#$convener = array("aarondigital@gmail.com","Peter Cole");
$convener = array($_GET['fromaddr'],  $_GET['fromname']);
$bounces = $_GET['bounces'];
$subject = $_GET['subject'];
$message_text = $_GET['body'];
$location = $_GET['location'];
$start = $_GET['start'];
$end = $_GET['end'];


list($orgemail, $orgname) = $convener;
//print( "Convener: ".$orgname."\nEmail :".$orgemail."\n<hr />");

$uid = NULL;
if (isset($_GET["uid"])) {
  $uid = $_GET["uid"];
  $sequence = $_GET["seq"];
} else {
  $sequence = 0;
  $uid = uniqid(); // TODO: make a better unique value
  // TODO: store the sequence and UID in the database so we can update later
}

////////////////////////////////////
//  Create the calendar attachment
////////////////////////////////////
   
$cal = new iCal($subject, $convener, $start, $end, $uid, $sequence);
$cal->setLocation($location)
  ->addAttendees($to)
  ->setBody($message_text);



//////////////////////////////////////
// Email creation and sending
//////////////////////////////////////
$message = Swift_Message::newInstance()
  ->setSubject($subject)
  ->setFrom(array($orgemail => $orgname))
  ->setReturnPath($bounces)
  ->setTo($to);



// Build depending on how you want to attach
switch ($_GET['attmeth']) {
  case ('inline'):
    $message
      ->setBody($cal->toString(), 'text/calendar; method=REQUEST');
      //      ->setEncoder(new Swift_Mime_ContentEncoder_RawContentEncoder());
    break;
  case ('attached'):
    $ical_attach = Swift_Attachment::newInstance()
      ->setFilename('invite.ics')
      ->setContentType('text/calendar; METHOD=REQUEST')
      ->setBody($cal->toString())
      ->setEncoder(new Swift_Mime_ContentEncoder_RawContentEncoder())
      ->setDisposition('attachment');

    $message
      ->setBody($message_text)
      ->addPart('<p>I am HTML</p>','text/html')
      ->attach($ical_attach);
    break;
    default:
      die("Error on attachment type");
}

if (isset($_GET['send']) and $_GET['send'] == "true") {
//  $transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
  $transport = Swift_SmtpTransport::newInstance('mail.tawazz.net',587)
     ->setUsername('appointmate@tawazz.net')
     ->setPassword('z^mPHnbgVZon');
;
  $mailer = Swift_Mailer::newInstance($transport);
  $result = $mailer->send($message, $failures);
  printf("Send %d message(s)\n", $result);
  //  print_r($failures);
} else {
  ?><div style="border: 1px solid black; width:80%; height:20px; text-align:center;"><a href="<?php echo $_SERVER['REQUEST_URI']."&send=true" ?>">Send this</a></div><?php 
}


echo "<pre>";
echo $message;
echo "\n</pre><hr />\n";


?>
<hr />
</pre>
</body>
</html>
