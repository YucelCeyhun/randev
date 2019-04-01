<?php

defined('BASEPATH') or exit('No direct script access allowed');

class AppointmentSelectAjax extends CI_Controller
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
            $mapAddress = StripInput($this->input->post("address"));
            $mapLatlng = StripInput($this->input->post("latlng"));
            $neighborhood = StripInput($this->input->post("neighborhood"));
            $district = StripInput($this->input->post("district"));


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
            $this->form_validation->set_rules("address", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("neighborhood", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("district", "Randevu Adresi", "trim|required");
            $this->form_validation->set_rules("latlng", "Randevu Adresi", "trim|required|regex_match[/^[1-9][0-9]+.[0-9]+,[1-9][0-9]+.[0-9]+$/]");

            if ($this->form_validation->run()) {

                $destLatLng = explode(',', $mapLatlng);
                $userId = $this->session->userdata('id');
                $this->load->Model('AppointmentModel');
                $resutsEngineers = $this->AppointmentModel->GetEngineersAsArray($userId);
                $this->load->library('appointmentutilities');
                $engineersDist = $this->SortForHomeDistance($resutsEngineers, $destLatLng);
                $colHome = $this->appointmentutilities->EngineersHomeDistance($engineersDist);

                $engineersQuantity = $this->SortForQuantity($userId,$datepicker,$resutsEngineers);
                $colQauntity=$this->appointmentutilities->EngineersQuantities($engineersQuantity,$total);

                $engineerNearRoute = $this->SortEngineerNearRoute($userId,$datepicker,$resutsEngineers,$destLatLng);
                $colNearRoute = $this->appointmentutilities->EngineersNearRoutes($engineerNearRoute,$datepicker);

                $engineerQuantityExtra = $this->EngineerQantityExtra($userId, $datepicker, $resutsEngineers, $total);
                $colQauntityExtra = $this->appointmentutilities->EngineersQuantitiesEx($engineerQuantityExtra);

                $returnedData = array(
                    'val' => 1,
                    'tableList' => '<div class="row">'.$colHome.$colQauntity.$colNearRoute.$colQauntityExtra.'</row>' 
                );
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


    private function GetJsonValue($Olat, $Olng, $Dlat, $Dlng)
    {

        $key = "AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s";
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" . $Olat . "," . $Olng . "&destinations=" . $Dlat . "," . $Dlng . "&key=" . $key . "&language=tr&region=tr";
        $jsonVal = file_get_contents($url);
        $val = json_decode($jsonVal);
        $dist = $val->rows[0]->elements[0]->distance->text;
        $resultDist = explode(" ", $dist);

        return str_replace(",", ".", "$resultDist[0]");
    }

    private function SortForHomeDistance($resutsEngineers, $destLatLng)
    {
        $orderList = array();
        foreach ($resutsEngineers as $engineer) {
            $dist = $this->GetJsonValue($engineer->lat, $engineer->lng, $destLatLng[0], $destLatLng[1]);
            $orderList[] = array(
                "distance" => $dist,
                "name" => $engineer->name,
            );
        }
        $distance = array();
        foreach ($orderList as $list) {
            $distance[] = $list['distance'];
        }
        array_multisort($distance, SORT_ASC, $orderList);

        return $orderList;
    }

    private function SortForQuantity($userId, $date, $resutsEngineers)
    {
        $quantity = 0;
        $engineerQuantity = array();
        $this->load->Model('AppointmentModel');
        foreach ($resutsEngineers as $engineer) {
            $query = $this->AppointmentModel->GetAppointmentsForUserArray($userId, $date, $engineer->id);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $app) {
                    $quantity += $app->quantity;
                }
            }

            $engineerQuantity[] = array(
                "name" => $engineer->name,
                "quantity" => $quantity,
                "id" => $engineer->id
            );

            $quantity = 0;
        }

        $qan = array();

        foreach ($engineerQuantity as $list) {
            $qan[] = $list['quantity'];
        }

        array_multisort($qan, SORT_ASC, $engineerQuantity);

        return $engineerQuantity;
    }

    private function EngineerQantityExtra($userId, $date, $resutsEngineers, $appointmentQuantity)
    {
        $engineerQuantityEx = array();
        $engineerQuantity = $this->SortForQuantity($userId, $date, $resutsEngineers);

        
        foreach ($engineerQuantity as $engineerQ) {
            if (($engineerQ["quantity"] + $appointmentQuantity) <= 5) {
                $engineerQuantityEx[] = $engineerQ;
            }
        }

        return $engineerQuantityEx;
    }

    private function SortEngineerNearRoute($userId, $date, $resutsEngineers, $destLatLng )
    {
        $this->load->Model('AppointmentModel');
        $engineerAppointmentsAll = array();
        foreach ($resutsEngineers as $engineer) {
            $query = $this->AppointmentModel->GetAppointmentsForUserArray($userId, $date, $engineer->id);
            $engineerAppointments = array();
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $app) {
                    $distance = $this->GetJsonValue($destLatLng[0], $destLatLng[1], $app->lat, $app->lng);
                    $engineerAppointments[] = array(
                        'id' => $app->id,
                        'builtName' => $app->builtName,
                        'address' => $app->address,
                        'distance' => $distance
                    );
                }

                $listDistnace = array();
                foreach ($engineerAppointments as $list) {
                    $listDistnace[] = $list['distance'];
                }
                array_multisort($listDistnace, SORT_ASC, $engineerAppointments);

                $engineerAppointmentsAll[] = array(
                    "name" => $engineer->name,
                    "appointments" => $engineerAppointments[0],
                    "id" => $engineer->id
                );
            }

            $mylist = array();
            foreach ($engineerAppointmentsAll as $list) {
                $mylist[] =  $list["appointments"]['distance'];
            }
            array_multisort($mylist, SORT_ASC, $engineerAppointmentsAll);
        }
        return $engineerAppointmentsAll;
    }
}
