<?php
class Input{
    public static function exist($type = 'post'){
        switch($type){
            case 'post':
                return (!empty($_POST)) ? TRUE : FALSE;
                break;
            case 'get' :
                return (!empty($_GET)) ? TRUE : FALSE;
                break;
            default:
                return FALSE;
                break;
        }
    }

    public static function get($item){
        if(isset($_POST[$item])){
            return $_POST[$item];
        }
        if(isset($_GET[$item])){
            return $_GET[$item];
        }

        return "";
    }
}
?>