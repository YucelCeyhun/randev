<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index(){

        if($this->session->userdata("login")){
            redirect(base_url('panel'),'refresh');
        }else{
            $this->load->view("LoginView");
        }
    }

}