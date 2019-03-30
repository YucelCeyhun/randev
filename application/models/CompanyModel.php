<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CompanyModel extends CI_Model
{
    public function CreateCompany($insertData)
    {
        return $this->db->insert('companies',$insertData);
    }

    public function GetUsersAsArray(){
       $result = $this->db->order_by('username','ASC')->where("auth",0)->get('users')->result();
        return $result;
    }
}
