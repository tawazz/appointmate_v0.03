<?php

    class DB{
        private static $_instance = NULL;
        private $_pdo,
        $_query,
        $_error=false,
        $_result,
        $count=0;

        private function __construct(){
            try{
                $this->_pdo = new PDO('mysql:Host= 127.0.0.1;dbname=tawazzne_appointmate','tawazzne_admin','9lV2TDfJHfet');
            }catch(PDOException $e){
                die($e->getMessage());
            }
        }
        public static function connect(){
            if(!isset(self::$_instance)){
                self::$_instance=new DB();
            }
            return self::$_instance;
        }

        public function lastIndex(){
            return $this->_pdo->lastInsertId();
        }

        public function query($sql,$params= array()){
            $this->_error = FALSE;
            if($this->_query = $this->_pdo->prepare($sql)){
                $i=1;
                if(count($params)){
                    foreach($params as $param){
                        $this->_query->bindValue($i,$param);
                        $i++;
                    }
                }
                if($this->_query->execute()){
                    $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    $this->_count = $this->_query->rowCount();
                }else{
                    $this->_error = TRUE;
                }
            }
            return $this;
        }
        public function action($action,$table,$where= array()){
            if(count($where === 3)){
                $operators = array('=','>','<','>=','<=');
                $field = $where[0];
                $operator= $where[1];
                $value= $where[2];

                if(in_array($operator,$operators)){
                    $sql = $action. " FROM ". $table." WHERE " .$field." ". $operator." ? " ;
                    if(!$this->query($sql,array($value))->error()){
                        return $this;
                    }
                }
            }
            return FALSE;
        }
        /**
        get (table to get infomation,where parameters)

        example to get results

          $users = DB::getInstance()->query('Select * from users');

          if(!$users->count()){
              echo 'no such user found';
          }else{
            foreach($users->result() as $user){
                echo $user->username;
            }
          }
        **/
        public function get($table,$where){
            return $this->action('SELECT *',$table,$where);
        }
        public function delete($table,$where){
             return $this->action('DELETE',$table,$where);
        }
        public function result(){
            return $this->_result;
        }
        public function first(){
            return $this->_result[0];
        }
        public function error(){
            return $this->_error;
        }
        public function count(){
            return $this->_count;
        }
        /**
        inserts(table name ,array containing parameters u wish to insert )

        example 

        $insert = DB::getInstance()-> insert('users',array(
        'username'=> 'tawanda',
        'password'=> 'tawazz23',
        'id'=>1
       ));

        **/
        public function insert($table,$params= array()){
            if(count($params)){
                $keys= array_keys($params);
                $values= NULL;
                $i=1;
                $sql = "insert into ".$table."( ";

                foreach( $keys as $key){
                   $sql = $sql ."$key";
                   if($i<count($params)){
                       $sql.=', ';
                   } 
                   //$values .= "'$params[$key]'";
                   $values.='?';
                   if($i<count($params)){
                       $values.=', ';
                       $i++;
                   } 
                }
                $sql = $sql.")VALUES (".$values.")";
                //echo $sql;
                if(!$this->query($sql,$params)->error()){
                    return TRUE;
                } else {
		    echo $this->_pdo->errorInfo()[2];
                }
            }
            return FALSE;

        }
        /**

        update (table name, array with values {not assosiative array}, assosiative array with value parameter pairs)
        
         example
        $update = DB::getInstance()->update('users',array('id','=', '1'),array(
           'username'=> 'tawazz'
           ));

        **/
        public function update($table,$pk=array(),$params=array()){
            if(count($params)){
                $keys = array_keys($params);
                $values = NULL;
                $i=1;
                $sql = "UPDATE ".$table." SET ";
                foreach( $keys as $key){
                    $sql.= $key." = '$params[$key]'";
                    if($i<count($params)){
                       $sql .=', ';
                       $i++;
                   } 
                }
                if(count($pk)===3){
                    $operators = array('=','>','<','>=','<=');
                    $field = $pk[0];
                    $operator= $pk[1];
                    $value= $pk[2];

                    if(in_array($operator,$operators)){
                        $sql .= " WHERE " .$field." ". $operator." ? " ;
                        //echo $sql;
                        if(!$this->query($sql,array($value))->error()){
                            return $this;
                        }
                    }
                }
            }
            return FALSE;
        }

        public function autoInc($table,$column){
            if(!$this->query("Alter table $table modify $column int(11) AUTO_INCREMENT")->error()){
                return $this;   
            }
            return FALSE;
        }
    }
?>