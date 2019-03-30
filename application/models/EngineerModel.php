<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class EngineerModel extends CI_Model
{
    public function CreateEngineer($insertData)
    {
        return $this->db->insert('engineers',$insertData);
    }

    public function GetUsersAsArray(){
       $result = $this->db->order_by('username','ASC')->where("auth",0)->get('users')->result();
        return $result;
    }
}
