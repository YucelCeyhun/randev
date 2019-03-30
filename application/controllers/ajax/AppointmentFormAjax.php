<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentFormAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
        $this->load->helper("datefiltertool_helper");
    }
//datepicker:datepicker.val(),builtname:builtname.val(),companies:companies.val(),total:total
    public function index()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") == 0) {
        
            $datepicker = StripInput($this->input->post("datepicker"));
            $builtname = StripInput($this->input->post("builtname"));
            $companies = StripInput($this->input->post("companies"));
            $total = StripInput($this->input->post("total"));


            $this->form_validation->set_message(
                array(
                    "required"      => "Gerekli alanları doldurun",
                    "matches"       => "Şifreler uyuşmuyor",
                    "is_unique"     => "{field} başka bir kullanıcı tarafından kullanılıyor.",
                    "max_length"    => "{field} {param}' dan fazla karakter olamaz",
                    "min_length"    => "{field} en az {param} karakter içermelidir.",
                    "valid_email"   => "Geçerli bir email adresi giriniz.",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "DateCheck"     => "{field} uygun değil",
                    "less_than_equal_to" => "{field} miktarı {param}' dan fazla olamaz"
                )
            );

            $this->form_validation->set_rules("datepicker","Randevu Tarihi","trim|required|callback_DateCheck");
            $this->form_validation->set_rules("builtname", "Bina Adı","trim|required|max_length[150]|min_length[3]");
            $this->form_validation->set_rules("companies", "Firma","trim|required|max_length[10]|numeric");
            $this->form_validation->set_rules("total", "Toplam Randevu","trim|required|numeric|less_than_equal_to[5]");

            if ($this->form_validation->run()){
                $returnedData = Array(
                    'val' => 1,
                );
            }else{
                $returnedData = Array(
                    'val' => -1,
                    'msg' => validation_errors()
                );
            }

            echo json_encode($returnedData);


        }

    }

    public function DateCheck($date)
    {
        return DateCalculator($date);
    }
    
}