<?php

function TokenControle(){
    $CI =& get_instance();
    if(!$CI->session->userdata("login") || !$CI->session->userdata("id")){
        die(redirect(base_url()));
        return "get out there";
    }
}