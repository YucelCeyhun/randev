<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentExcelListAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper("formtool_helper");
        $this->load->helper("datefiltertool_helper");
    }

    public function index()
    {
           
       if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") >= 0) {
        
            $datepickerFrom = StripInput($this->input->post("datepickerFrom"));
            $datepickerTo = StripInput($this->input->post("datepickerTo"));
            $engineers = StripInput($this->input->post("engineers"));


            $this->form_validation->set_message(
                array(
                    "required"      => "Gerekli alanları doldurun",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "DateCheck"     => "{field} uygun değil"
                )
            );

            $this->form_validation->set_rules("datepickerFrom", "Tarih Başlangıcı", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("datepickerTo", "Tarih Sonu", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("engineers", "Randevu Numarası","trim|required|numeric");
            
            if ($this->form_validation->run())
            {
                $returnedData = Array(
                    'val' => 1,
                    'msg' => 'Başarıyla Oluşturuldu.',
                );

            }else {
                $returnedData = Array(
                    'val' => -1,
                    'msg' => validation_errors()
                );
            }
            echo json_encode($returnedData);
        }else{
            die("get out there");
        }

    }

    public function DateCheck($date)
    {
        return DateCalculator($date);
    }

}