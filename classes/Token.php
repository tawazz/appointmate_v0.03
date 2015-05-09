<?php
    include_once('Session.php');
    class Token{
        
        public static function generate(){
            return Session::put('token',md5(uniqid()));
        }

        public static function check($token){
            $tokenname = 'token';

            if(Session::exists($tokenname) && $token === Session::get($tokenname)){
                Session::delete($tokenname);
                return TRUE;
            }
            return FALSE;
        }
    }
?>
