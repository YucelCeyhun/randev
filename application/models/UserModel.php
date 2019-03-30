<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("passwordtool_helper");
    }

    public function CreateUser($insertData)
    {
        $mainData = $insertData;
        unset($mainData['companies']);
        unset($mainData['engineers']);
        return $this->db->insert('users',$mainData);
    }
}
