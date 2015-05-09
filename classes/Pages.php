<?php
    include_once('db.php');
    class Pages{
         private $db;

        public function __construct(){
            $this->db = DB::connect();
        }
        public function fetchPages(){
            $get_pages = $this->db->query("select * from pages order by time desc");

            return $get_pages->result();
        }

        public function getPage($id){
            $page = $this->db->get('pages',array("id","=",$id));

            return $page->first();
        }

        public  function create($params= array()){
            return $this->db->insert('pages',$params);
        }
    }
?>
