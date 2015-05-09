<?php

class iCal
{
  private $_uid,
    $_sequence,
    $_content,
    $_attendees,
    $_title, 
    $_start_date,
    $_end_date,
    $_location,
    $_body,
    $_convener,
    $_prod_id;  #TODO: make this in config file

  public function __construct($title, $convener, $start_date, $end_date, $uid, $sequence = 0)
  {
    $this->_title = $title;
    $this->_start_date = $start_date;
    $this->_end_date = $end_date;
    $this->_uid = $uid;
    $this->_convener = $convener;
    $this->_sequence = $sequence;
    $this->_attendees = "";
    $this->_body = "\n";    
    $this->_location = "\n";
  }

  public function addAttendees($attendees) {
    foreach ($attendees as $emailaddr => $dispname) {
      $this->_attendees .= "ATTENDEE;CN=".$dispname.";RSVP=TRUE:mailto:".$emailaddr."\r\n";
      return $this;
    }   
  }

  public function setBody($body) {
    $this->_body = $body;
    return $this;
  }

  public function setLocation($location) {
    $this->_location = $location;
    return $this;
  }

  private function genContent() {
    $prod_id = "//iTech Solutions//NONSGML AppointMate//EN";

    $this->content = "BEGIN:VCALENDAR\r\nVERSION:2.0\r\nMETHOD:REQUEST\r\nPRODID:-".$prod_id."\r\n";
    $this->content .= "X-MS-OLK-FORCEINSPECTOROPEN:TRUE\r\nBEGIN:VEVENT\r\n";   

    $this->content .= $this->_attendees;

    $this->content .= "DTSTART:".$this->_start_date."\r\n";
    $this->content .= "DTEND:".$this->_end_date."\r\n";

    $this->content .= "UID:".$this->_uid."\r\n";
    $this->content .= "DESCRIPTION:".$this->_body."\r\nSUMMARY;LANGUAGE=en-au:".$this->_title."\r\n";
    $this->content .= "LOCATION: ".$this->_location."\r\n";
    $this->content .= "SEQUENCE:".$this->_sequence."\r\n";
 #   $this->content .= "STATUS:DRAFT\r\n";
    list($orgemail, $orgname) = $this->_convener;
    $this->content .= "ORGANIZER;CN=\"".$orgname."\":mailto:".$orgemail."\r\n";
#    $this->content .= "X-ALT-DESC;FMTTYPE=text/html:<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 3.2//EN\">\r\n<HTML>\r\n<HEAD>\r\n<META NAME=\"Generator\" CONTENT=\"MS Exchange Server version rmj.rmm.rup.rpr\">\r\n<TITLE></TITLE>\r\n</HEAD>\r\n<BODY>\r\n<!-- Converted from text/rtf format -->\r\n\r\n<P DIR=LTR><SPAN LANG=\"en-gb\"></SPAN></P>\r\n\r\n</BODY>\r\n</HTML>X-MICROSOFT-CDO-BUSYSTATUS:TENTATIVE\r\nX-MICROSOFT-CDO-IMPORTANCE:1\r\nX-MICROSOFT-CDO-INTENDEDSTATUS:BUSY\r\nX-MICROSOFT-DISALLOW-COUNTER:FALSE\r\nX-MS-OLK-APPTSEQTIME:20140826T151110Z\r\nX-MS-OLK-AUTOSTARTCHECK:FALSE\r\nX-MS-OLK-CONFTYPE:0";
    $this->content .= "END:VEVENT\r\n";
    $this->content .= "END:VCALENDAR\r\n";
  }

  public function toString() 
  {

    $this->genContent();
    return $this->content;
  }
}



  /* params: convener = tuple of (display name, email address) for the organiser of the meeting
             summary  = the subject of the calendar appointment
             start_date & end_date = ISO format start and end of the meeting
             to = array of attendees
             uid = optional UID if recreating (e.g. purpose is update).  
             sequence = as for uid if recreating otherwise default to 1
  */
