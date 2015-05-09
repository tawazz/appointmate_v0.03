<?php
    class File{

        private $file;
        private $filename;
        private $file_tmp;
        private $file_size;
        private $file_error;
        private $max_size;
        private $allowed = array('csv','txt');

        public function __construct($fileObj){
            $this->file = $fileObj;
            $this->filename = $this->file['name'];
            $this->file_tmp = $this->file['tmp_name'];
            $this->file_size = $this->file['size'];
            $this->file_error = $this->file['error'];
            $this->max_size = 1024;
        }
        public function getFileObj(){
            return $this->file;
        }
        public function getFileExt(){

             $file_ext= explode('.',$this->filename);
             $file_ext = strtolower(end($file_ext));

             return $file_ext;
        }

        public function getFileName(){
            return $this->filename;
        }

        public function getFileTempName(){
            return $this->file_tmp;
        }

        public function getFileSize(){
            return $this->file_size;
        }

        public function error(){
             if($this->file_error === 0){
                 return FALSE;
             }else{
                 return TRUE;
             }
             
        }

        public function isAllowed(){
            
            return in_array($this->getFileExt(),$this->allowed);
        }

        public function setAllowed($allowed){
            $this->allowed = $allowed;
        }

        public function setMaxSize($size){
            $this->max_size = $size;
        }

         public function inSizeLimit($size){
            return $this->getFileSize() <= $size;
        }

         public function fileLoc(){
            return $this->file['tmp_name'];
        }

    }
?>

