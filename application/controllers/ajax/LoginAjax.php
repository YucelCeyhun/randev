<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index()
    {
        if ($this->input->is_ajax_request()) {
            $returnData = array();
            $username = StripInput($this->input->post("username"));
            $password = StripInput($this->input->post("password"));
            if (CheckInput($username) || CheckInput($password)) {
                $val = -1;
                $msg = "Kullanıcı adı veya şifre alanı boş olamaz.";
            } else {
                $this->load->model('LoginModel');
                $result = $this->LoginModel->Control($username, $password);
                if ($result['value']) {
                    $userData = array(
                        'id' => $result['id'],
                        'user' => $username,
                        'login' => true,
                        'auth' => $result['auth']
                    );
                    $this->session->set_userdata($userData);
                    $val = 1;
                    $msg = "Giriş Başarılı.";
                    $urlDirect = base_url("panel/");
                    $returnData = Array(
                        "val" => $val,
                        "msg" => $msg,
                        "urlDirect" => $urlDirect
                    );
                    echo json_encode($returnData);
                    return;
                }

                $val = 0;
                $msg = "Kullanıcı adı ve şifre uyuşmuyor.";
            }

            $returnData = Array(
                "val" => $val,
                "msg" => $msg
            );
            echo json_encode($returnData);

        }else{
            die("No direct script access allowed");
        }
    }

}