<?php
    function PasswordEncode($password){
        $hash = password_hash(sha1(md5($password)),PASSWORD_BCRYPT);
        return $hash;
    }

    function PasswordControl($password,$hash){
        $password = sha1(md5($password));
        return password_verify($password, $hash);
    }

?>