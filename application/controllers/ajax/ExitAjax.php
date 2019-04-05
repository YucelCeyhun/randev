<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ExitAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index()
    {
           
       if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") >= 0) {
        
            $userData = array('id','user','login','auth');
            $this->session->unset_userdata($userData);
            $returnedData = Array(
                'val' => 1,
                'msg' => 'Başarıyla Çıkış Yapıldı.',
                'urlDirect' => base_url()
            );
            echo json_encode($returnedData);
            

        }else{
            die("get out there");
        }


    }
    
}