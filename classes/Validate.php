<?php
    require_once 'db.php';

    class Validate{
      private $_passed = FALSE,
              $_errors = array(),
              $_db= NULL;
                
        public function __construct(){
            $this->_db = DB::connect();
        }

        public function check($source,$items=array()){
            foreach($items as $item=>$rules){
                foreach($rules as $rule=>$rule_value){
                    $value = $source[$item];
                    if($rule === 'required' && empty($value)){
                        $this->addError("{$item} is required. ");
                    }else if(!empty($value)){
                        switch($rule){
                            case 'min':
                                if(strlen($value) < $rule_value){
                                    $this->addError("{$item} must be minimum of {$rule_value} characters. <br/>");
                                }
                                break;
                            case 'max':
                                if(strlen($value) > $rule_value){
                                    $this->addError("{$item} must be maximum of {$rule_value} characters.<br/> ");
                                }
                                break;
                            case 'matches':
                                if($value != $source[$rule_value]){
                                    $this->addError("{$rule_value} must be match  {$item}. <br/>");
                                }
                                break;
                            case 'unique':
                                $check = $this->_db->get($rule_value,array($item,'=',$value));
                                if($check->count()){
                                    $this->addError("{$item} already exist, choose another {$item}. <br/>");
                                }
                                break;
                        }
                    }
                }
            }

            if(empty($this->_errors)){
                $this->_passed = TRUE;
            }

            return $this;
        }

        private function addError($error){
            $this->_errors[]= $error;
        }

        public function errors(){
            return $this->_errors;
        }

        public function passed(){
            return $this->_passed;
        }
    }
?>