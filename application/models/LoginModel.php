<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class LoginModel extends CI_Model
{
    public function __construct()
{
    parent::__construct();
    $this->load->helper("passwordtool_helper");
}

    public function Control($username,$password){

    $get = $this->db->where("username",$username)->get('users');
    if($this->db->affected_rows()){
        $row = $get->row();
        if(PasswordControl($password,$row->password)){
            return Array(
                'value' => 1,
                'auth' => $row->auth,
                'id' => $row->id
            );
        }
    }
}
}
