<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCreateAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
        $this->load->helper("passwordtool_helper");
    }

    public function index()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") > 0) {
            $username = StripInput($this->input->post("username"));
            $password = StripInput($this->input->post("password"));
            $passwordRepeat = StripInput($this->input->post("passwordRepeat"));
            $tel = StripInput($this->input->post("tel"));
            $email = StripInput($this->input->post("email"));
            $companies = $this->input->post("companies");
            $engineers =$this->input->post("engineers");


            $this->form_validation->set_message(
                array(
                    "required"      => "Gerekli alanları doldurun",
                    "matches"       => "Şifreler uyuşmuyor",
                    "is_unique"     => "{field} başka bir kullanıcı tarafından kullanılıyor.",
                    "max_length"    => "{field} {param}' dan fazla karakter olamaz",
                    "min_length"    => "{field} en az {param} karakter içermelidir.",
                    "valid_email"   => "Geçerli bir email adresi giriniz.",
                    "numeric"       => "{field} harf veya özel karakter içeremez"
                )
            );
            $this->form_validation->set_rules("username", "Ad","trim|required|is_unique[users.username]|max_length[50]|min_length[3]");
            $this->form_validation->set_rules("password", "Şifre","trim|required|max_length[50]|min_length[8]|matches[passwordRepeat]");
            $this->form_validation->set_rules("passwordRepeat","Şifre Tekrar", "trim|required|max_length[50]|min_length[8]");
            $this->form_validation->set_rules("tel", "Telefon Numarası","trim|required|max_length[10]|min_length[10]|numeric");
            $this->form_validation->set_rules("email", "Email adresi","trim|required|valid_email");


            if ($this->form_validation->run())
            {
                $insertData = Array(
                    'username' => $username,
                    'password' => PasswordEncode($password),
                    'tel' => $tel,
                    'email' => $email,
                    'companies' => $companies,
                    'engineers' => $engineers
                );
                $this->load->model('UserModel');
                if($this->UserModel->CreateUser($insertData)){
                    $returnedData = Array(
                        'val' => 1,
                        'msg' => 'Başarıyla Ekledi',
                        'urlDirect' => base_url('panel/users/')
                    );
                    echo json_encode($returnedData);
                }
            }else {
                $returnedData = Array(
                    'val' => -1,
                    'msg' => validation_errors()
                );
                echo json_encode($returnedData);
            }
        }else{
            die("get out there");
        }

    }

}