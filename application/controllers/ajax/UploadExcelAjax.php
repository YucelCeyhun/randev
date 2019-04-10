<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UploadExcelAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") >= 0) {

            $userId = $this->session->userdata("id");
            $userName = $this->session->userdata('user');
            $filename = $_FILES['fileexcel']['name'];
            $filename = explode('.',$filename);

            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'xlsx|xls';
            $config['file_name'] = uniqid($userName.'_',TRUE).'.'.$filename[1];
            $config['max_size'] = 512;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('fileexcel'))
            {
               $returnedData = array(
                    'val' => -1,
                    'msg' => $this->upload->display_errors()
                );
            }else{
                $returnedData = array(
                    'val' => 1,
                    'msg' => "okey"
                );
            }

            echo json_encode($returnedData);
           
        }
    }

}
