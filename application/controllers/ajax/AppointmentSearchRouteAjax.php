<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AppointmentSearchRouteAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
        $this->load->helper("datefiltertool_helper");
    }

    public function index()
    {
        if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") == 0) {

            $datepicker = StripInput($this->input->post("datepicker"));
            $engineers = StripInput($this->input->post("engineers"));

            $this->form_validation->set_message(
                array(
                    "required"      => "{field} Gerekli alanları doldurun",
                    "matches"       => "Şifreler uyuşmuyor",
                    "is_unique"     => "{field} başka bir kullanıcı tarafından kullanılıyor.",
                    "max_length"    => "{field} {param}' dan fazla karakter olamaz",
                    "min_length"    => "{field} en az {param} karakter içermelidir.",
                    "valid_email"   => "Geçerli bir email adresi giriniz.",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "DateCheck"     => "{field} uygun değil",
                    "less_than_equal_to" => "{field} miktarı {param}' dan fazla olamaz",
                    "greater_than" => "mühendis seçin.",
                    "regex_match"   => "{field} uygun değil"
                )
            );
            $userId = $this->session->userdata("id");
            $this->form_validation->set_rules("datepicker", "Randevu Tarihi", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("engineers", "Mühendis", "trim|required|numeric|greater_than[0]");
            if ($this->form_validation->run()) {
           
            
            $this->load->model("AppointmentModel");
            $get = $this->AppointmentModel->GetAppointmentEngineerWithId($userId,$datepicker,$engineers);
            $result = $get->result();

            $returnedData = array(
                'val' => 1,
                'msg' => '<div id="map"></div>'
            );
            echo json_encode($returnedData);

        }else {
            $returnedData = array(
                'val' => -1,
                'msg' => validation_errors()
            );
            echo json_encode($returnedData);
        }
    }
}


    public function DateCheck($date)
    {
        return DateCalculator($date);
    }

}
