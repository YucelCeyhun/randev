<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class EngineerCreateAjax extends CI_Controller
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
            $tel = StripInput($this->input->post("tel"));
            $email = StripInput($this->input->post("email"));
            $user = StripInput($this->input->post("user"));
            $mapAddress = StripInput($this->input->post("mapAddress"));
            $mapLatLng = StripInput($this->input->post("mapLatLng"));
            

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
            $this->form_validation->set_rules("name", "Ad","trim|required|is_unique[engineers.name]|max_length[50]|min_length[3]");
            $this->form_validation->set_rules("tel", "Telefon Numarası","trim|required|max_length[10]|min_length[10]|numeric");
            $this->form_validation->set_rules("email", "Email adresi","trim|required|valid_email");
            $this->form_validation->set_rules("mapAddress", "Adres","trim|required|max_length[225]|min_length[8]");
            $this->form_validation->set_rules("mapLatLng","Adres Kordinatları", "trim|required|max_length[100]|min_length[3]");
            $this->form_validation->set_rules("user","Randevucu Idsi", "trim|max_length[10]|numeric");
            if ($this->form_validation->run())
            {
                $coord = explode(',',$mapLatLng);
                $insertData = Array(
                    'name' => $name,
                    'address' => $mapAddress,
                    'tel' => $tel,
                    'email' => $email,
                    'userId' => $user,
                    'lat' => $coord[0],
                    'lng' => $coord[1] 
                );
                $this->load->model('EngineerModel');
                if($this->EngineerModel->CreateEngineer($insertData)){
                    $returnedData = Array(
                        'val' => 1,
                        'msg' => 'Başarıyla Oluşturuldu.',
                        'urlDirect' => base_url('panel/engineers/')
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