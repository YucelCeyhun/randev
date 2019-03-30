<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CompanyCreateAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index()
    {
           
       if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") > 0) {
        
            $name = StripInput($this->input->post("name"));
            $address = StripInput($this->input->post("address"));
            $tel = StripInput($this->input->post("tel"));
            $email = StripInput($this->input->post("email"));
            $user = StripInput($this->input->post("user"));


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
            $this->form_validation->set_rules("name", "Ad","trim|required|max_length[150]|min_length[3]");
            $this->form_validation->set_rules("tel", "Telefon Numarası","trim|required|max_length[10]|min_length[10]|numeric");
            $this->form_validation->set_rules("email", "Email adresi","trim|valid_email");
            $this->form_validation->set_rules("address", "Adres","trim|required|max_length[225]|min_length[8]");
            $this->form_validation->set_rules("user","Randevucu Idsi", "trim|max_length[10]|numeric");

            
            if ($this->form_validation->run())
            {
               
                $insertData = Array(
                    'name' => $name,
                    'address' => $address,
                    'tel' => $tel,
                    'email' => $email,
                    'userId' => $user,
                );
                $this->load->model('CompanyModel');
                if($this->CompanyModel->CreateCompany($insertData)){
                    $returnedData = Array(
                        'val' => 1,
                        'msg' => 'Başarıyla Oluşturuldu.',
                        'urlDirect' => base_url('panel/companies/')
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