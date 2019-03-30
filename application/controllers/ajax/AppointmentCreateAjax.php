<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AppointmentCreateAjax extends CI_Controller
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
            $builtname = StripInput($this->input->post("builtname"));
            $companies = StripInput($this->input->post("companies"));
            $total = StripInput($this->input->post("total"));
            $controlee = StripInput($this->input->post("controlee"));
            $controlen = StripInput($this->input->post("controlen"));
            $mapAddress = StripInput($this->input->post("address"));
            $mapLatlng = StripInput($this->input->post("latlng"));
            $neighborhood = StripInput($this->input->post("neighborhood"));
            $district = StripInput($this->input->post("district"));
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
                    "regex_match"   => "{field} uygun değil"
                )
            );

            $this->form_validation->set_rules("datepicker", "Randevu Tarihi", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("builtname", "Bina Adı", "trim|required|max_length[150]|min_length[3]");
            $this->form_validation->set_rules("companies", "Firma", "trim|required|max_length[10]|numeric");
            $this->form_validation->set_rules("total", "Toplam Randevu", "trim|required|numeric|less_than_equal_to[5]");
            $this->form_validation->set_rules("controlee", "Eksiklik Randevusu", "trim|numeric|less_than_equal_to[5]");
            $this->form_validation->set_rules("controlen", "Normal Randevu", "trim|numeric|less_than_equal_to[5]");
            $this->form_validation->set_rules("address", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("neighborhood", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("district", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("latlng", "Randevu Adresi", "trim|required|regex_match[/^[1-9][0-9]+.[0-9]+,[1-9][0-9]+.[0-9]+$/]");
            $this->form_validation->set_rules("engineers", "Mühendis", "trim|required|numeric");


                if ($this->form_validation->run()) {

                $destLatLng = explode(',', $mapLatlng);
                $dateArray = DateCovertNum($datepicker);
                $dateSql = DateConvertSql($datepicker);
                $userId = $this->session->userdata('id');
                
                if(!$this->RowCheck($builtname,$datepicker)){
                    $returnedData = array(
                        'val' => -1,
                        'msg' => "Randevu Zaten Mevcut."
                    );
                }else if($this->EngineerQantityControl($userId, $datepicker, $engineers, $total)){
                    $insertData = Array(
                        'userId' => $userId,
                        'companyId' => $companies,
                        'engineerId' => $engineers,
                        'builtName' => $builtname,
                        'address' => $mapAddress,
                        'neighborhood' =>$neighborhood,
                        'district' => $district,
                        'lat' => $destLatLng[0],
                        'lng' => $destLatLng[1],
                        'quantity' => $total,
                        'normalQuantity' => $controlen,
                        'secondQuantity' => $controlee,
                        'date' => $datepicker,
                        'dateSql' => $dateSql,
                        'day' => $dateArray['d'],
                        'month' => $dateArray['m'],
                        'year' => $dateArray['y']
                    );

                    $this->load->Model('AppointmentModel');
                    if($this->AppointmentModel->CreateAppointment($insertData)){
                        $returnedData = array(
                            'val' => 1,
                            'msg' => 'Başarıyla oluşturuldu.',
                            'urlDirect' => base_url('panel/appointments/')
                        );
                    }
                }else{
                    $returnedData = array(
                        'val' => -2,
                        'msg' => "Mühendis seçiminde sorun var."
                    );
                }

            } else {
                $returnedData = array(
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

    private function EngineerQantityControl($userId, $date, $engineer, $appointmentQuantity)
    {
       $quantity = 0;
        $this->load->Model('AppointmentModel');
            $query = $this->AppointmentModel->GetAppointmentsForUserArray($userId, $date, $engineer);
            $checkEngineer = $this->AppointmentModel->CheckEngineer($userId,$engineer);

            if(!$checkEngineer)
                return false;

            if ($query->num_rows() > 0) {
                foreach ($query->result() as $app) {
                    $quantity += $app->quantity;
                }
            }

        if(($quantity + $appointmentQuantity) <= 5)
            return true;

        return false;

    }

    public function RowCheck($built,$dateNow){
        $this->load->Model('AppointmentModel');
        return $this->AppointmentModel->CheckSameRow($built,$dateNow); 
    }

}
