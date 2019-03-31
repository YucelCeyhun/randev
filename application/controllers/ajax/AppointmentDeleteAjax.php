<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentDeleteAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("formtool_helper");
    }

    public function index()
    {
           
       if ($this->input->is_ajax_request() && $this->session->userdata("login") && $this->session->userdata("auth") >= 0) {
        
            $elementId = StripInput($this->input->post("elementId"));


            $this->form_validation->set_message(
                array(
                    "required"      => "Gerekli alanları doldurun",
                    "numeric"       => "{field} harf veya özel karakter içeremez"
                )
            );

            $this->form_validation->set_rules("elementId", "Randevu Numarası","trim|required|numeric");
 
            
            if ($this->form_validation->run())
            {
                $userId = $this->session->userdata("id");
                $this->load->model('AppointmentModel');
                
                if($this->session->userdata("auth") > 0){
                    $this->AppointmentModel->DeleteAppointmentForAdmin($elementId);
                    $returnedData = Array(
                        'val' => 1,
                        'msg' => 'Randevu silindi.',
                    );

                }else if($this->AppointmentModel->CheckAppointment($elementId,$userId)){
                    if($this->AppointmentModel->DeleteAppointment($elementId,$userId)){
                        $returnedData = Array(
                            'val' => 1,
                            'msg' => 'Randevu silindi.',
                        );
                    }
                }else{
                    $returnedData = Array(
                        'val' => -1,
                        'msg' => 'Bu randevu silmeye yetkiniz yok.',
                    );
                }
                echo json_encode($returnedData);
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