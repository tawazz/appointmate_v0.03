<?php
    include_once('db.php');
    class User{
        private $db;

        public function __construct(){
            $this->db = DB::connect();
        }

        public function create($fields= array()){
            if(!$this->db->insert('users',$fields)){
                throw new Exception('creating user failed');
            }
        }

        public function update($pk=array(),$fields= array()){
            if(!$this->db->update('users',$pk,$fields)){
                throw new Exception('updating user failed');
            }
        }
    }
?>
