<?php
date_default_timezone_set('Australia/Perth');
require_once("db.php");
    class Booking{
        private $id=NULL,$db=NULL,$count=0, $meeting_count =0, $attendee_count =0;
        private $organizer,$booking_name,$duration,$description,$location;
        private $booking = array();
        private $meetings = array();
	private $attendees = array();

        public function __construct($id=NULL){
            
            $this->db = DB::connect();

            if($id != NULL){
                $this->setup($id);
            }
        }
        //initialise all variables
        private function setup($id){
                $this->id = $id;
                $query = $this->db->get("booking",array("BookingId","=",$id));
                $this->booking = $query->first();
                $this->count = $query->count();
                $this->location = $this->booking->Location;
                $this->duration = $this->booking->MeetingDuration;
                $this->description = $this->booking->Description;
                $this->booking_name = $this->booking->BookingName;
        }
        /*
        *   create a booking 
            fields
                OrganizerId
                CreatedTS
                CreatedBy
                BookingName
                MeetingDuration
                Description
                Location

            usage 
                create(array(
                "OrganizerId" => 7,
                "BookingName"=>test
                ));
        */
        public function createBooking($fields=array()){
            $dateTime = date("Y-m-d H:i:s");
            $fields["CreatedTs"]= $dateTime;

            if(!$this->db->insert("booking",$fields)){
                throw new Exception('creating Booking failed');
            }

            $query = $this->db->get("booking",array("CreatedTS","=",$dateTime));
            $result = $query->first();
            $this->setup($result->BookingId); 
             
        }
        /*
            returns an array of meetings related to the booking
        */
        private function meetings($all = TRUE){
            if($all){
                $query = $this->db->query("select DATE_FORMAT(TimeStart,'%b-%d-%Y-%h:%i-%p')as Date ,MeetingId,AttendeeId from meeting where BookingId = ? order by Date",array($this->id));
                $this->meetings = $query->result();
                $this->meeting_count = $query->count(); 
            }else{
                $query = $this->db->query("select DATE_FORMAT(TimeStart,'%b-%d-%Y-%h:%i-%p')as Date ,MeetingId,AttendeeId from meeting where BookingId = ? AND AttendeeId IS NULL  order by Date",array($this->id));
                $this->meetings = $query->result();
                $this->meeting_count = $query->count(); 
            }  
        }

        /*
            create meetings related to this booking
        */
        public function createMeetings($st_date_time){
            $fields= array(
                "BookingId"=>$this->id,
                "TimeStart"=>$st_date_time
            );
            if(!$this->db->insert("meeting",$fields)){
                throw new Exception('creating Meeting failed');
            }
        }
	private function attendees() {
	  $query = $this->db->query("select * from attendee where BookingId = ?",array($this->id));
	  $this->attendees = $query->result();
	  $this->attendee_count = $query->count();
	}
	public function getAttendees() {
	  $this->attendees();
	  return $this->attendees;
	}
	public function numOfAttendees(){
	  $this->attendees();
	  return $this->attendee_count;
	}

        public function getBooking(){
            return $this->booking;
        }
        public function getMeetings($all = TRUE){
            $this->meetings($all);
            return $this->meetings;
        }
        public function count(){
            return $this->count;
        }
        public function numOfMeetings(){
            $this->meetings();
            return  $this->meeting_count;
        }

        public function getOrganizer(){
            $orgId = $this->booking->OrganizerId;
            $query = $this->db->get("users",array("id","=",$orgId));
            $result = $query->first();
            $this->organizer = $result->fname. " ".$result->lname;

            return $this->organizer;
        }
        
        public function getOrganizerEmail(){
            $orgId = $this->booking->OrganizerId;
            $query = $this->db->get("users",array("id","=",$orgId));
            $result = $query->first();
            $email = $result->email;

            return $email;
        }
        public function getOrganizerId(){
            return $this->booking->OrganizerId;
        }

        public function getLocation(){
            return $this->location;
        }
        public function getDuration(){
            return $this->duration;
        }
        public function getDescription(){
            return $this->description;
        }
        public function name(){
            return $this->booking_name;
        }

        public function getBookingId(){
            return $this->id;
        }
    }
?>