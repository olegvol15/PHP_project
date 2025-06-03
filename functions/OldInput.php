<?php
class OldInput{

    public static function set($data){
        $_SESSION['old'] = $data;
    }

    public static function get($key){
        return $_SESSION['old'][$key] ?? null;
    }

    public static function clear(){
        unset($_SESSION['old']);
    }
        
}