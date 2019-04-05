<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper("tokencontrole_helper");
        TokenControle();

        $username = $this->session->userdata('user');
        $userData= Array(
            'username' => $username
        );

        $menu = Array(
            'menuParent' => "",
            'menuChild' => ""
        );

        if($this->uri->segment(2))
            $menu['menuParent'] = $this->uri->segment(2);
            
        if($this->uri->segment(3))
            $menu['menuChild'] = $this->uri->segment(3);
        
        $this->load->view("PanelHeader");
        $this->load->view("PanelSideBar",$menu);
        $this->load->view("PanelContent",$userData);
    }

    public function index(){
        
        if(!$this->uri->segment(3)){
            $this->defaultPanel();
        }
    }

    private function defaultPanel(){

        $this->load->library('general');
        $userId = $this->session->userdata('id');
        $this->load->model('DefaultModel');
        $numEgineers = $this->DefaultModel->GetEngineersAsArray($userId)->num_rows();

        $date = date('Y-m-d');
        $numAppointments = $this->DefaultModel->GetAppointmentsArray($userId,$date)->num_rows();
        $menuData = Array(
            'content'=> $this->general->GeneralData($numEgineers,$numAppointments),
            'title' => 'Genel Bakış'
        );
        $this->load->view("PanelDefault",$menuData);
        $this->load->view("PanelFooter");
    }

    public function engineers(){
        
    if($this->session->userdata("login") && $this->session->userdata("auth") > 0)
    {
        $this->load->library('engineers');
        $engineers = $this->uri->segment(3);
        switch($engineers){
            case 'create':
                $this->load->model('EngineerModel');
                $result = $this->EngineerModel->GetUsersAsArray();
                $menuData = Array(
                    'content'=> $this->engineers->CreateEnginnerFrom($result),
                    'title' => 'Yeni Mühendis Oluştur'
                );
            break;
        }
    }else{
        $menuData = Array(
            'content' => 'BU ALANA ULAŞMAK İÇİN YETKİNİZ YOK.',
            'title' => 'YETKİ'
        );
    }

        $this->load->view("PanelMain",$menuData);
        $this->load->view("PanelFooter");
    }

    public function users(){

    if($this->session->userdata("login") && $this->session->userdata("auth") > 0)
    {
        $this->load->library('users');
        $users = $this->uri->segment(3);
        switch($users){
            case 'create':
                    $menuData = Array(
                        'content' => $this->users->CreateUserFrom(),
                        'title' => 'Yeni Randevucu Oluştur'
                    );
                break;
            default:
                $menuData = Array(
                    'content'=> $this->users->index(),
                    'title' => 'Randevucular'
                );
                break;
        }
    }else{
            $menuData = Array(
                'content' => 'BU ALANA ULAŞMAK İÇİN YETKİNİZ YOK.',
                'title' => 'YETKİ'
            );
    }

        $this->load->view("PanelMain",$menuData);
        $this->load->view("PanelFooter");
    }

    public function companies(){

    if($this->session->userdata("login") && $this->session->userdata("auth") > 0)
    {
        $this->load->library('companies');
        $companies = $this->uri->segment(3);
        switch($companies){
            case 'create':
                $this->load->model('CompanyModel');
                $result = $this->CompanyModel->GetUsersAsArray();
                $menuData = Array(
                    'content'=> $this->companies->CreateCompanyFrom($result),
                    'title' => 'Yeni Firma Oluştur'
                );
                break;
        }
    }else{
        $menuData = Array(
            'content' => 'BU ALANA ULAŞMAK İÇİN YETKİNİZ YOK.',
            'title' => 'YETKİ'
        );
    }

        $this->load->view("PanelMain",$menuData);
        $this->load->view("PanelFooter");
    }

    public function appointments(){

        $userId = $this->session->userdata('id');
        $appointments = $this->uri->segment(3);
        switch($appointments){
            case 'create':
                $this->load->library('appointments');
                $this->load->model('AppointmentModel');
                $userResult = $this->AppointmentModel->GetEngineersAsArray($userId);
                $companyResult = $this->AppointmentModel->GetCompaniesAsArray($userId);
                $menuData = Array(
                    'content'=> $this->appointments->CreateAppointmentForm($userResult,$companyResult),
                    'title' => 'Yeni Randevu Oluştur'
                );
            break;

            case 'page':
                if(empty($this->uri->segment(4))){
                    $page = 1;
                }else{
                    $page = strip_tags(trim($this->uri->segment(4)));
                }
                
                $limit = 5;
                $date = date('Y-m-d');
                $this->load->library('appointmentslist');
                $this->load->model('AppointmentModel');
                $appointmentfind = strip_tags(trim($this->input->get('appointmentfind')));

                if(!isset($appointmentfind))
                    $appointmentfind = "";

                
                $num = $this->AppointmentModel->GetAppointmentEngineer($userId,$date,$page,$appointmentfind)[1]; 
                $maxPage = ceil($num / $limit);
                if($page > $maxPage)
                    $page = $maxPage;
                
                if($page < 1)
                    $page = 1;

                $get = $this->AppointmentModel->GetAppointmentEngineer($userId,$date,$page,$appointmentfind);

                $menuData = Array(
                    'content'=> $this->appointmentslist->DefaultAppointments($get,$maxPage,$page,$appointmentfind),
                    'title' => 'Randevular'
                );

            break;

            case 'routelist':
                $this->load->library('appointmentsroutelist');
                $this->load->model('AppointmentModel');
                $engineers = $this->AppointmentModel->GetEngineersAsArray($userId);
                
                $menuData = Array(
                    'content'=> $this->appointmentsroutelist->RouteList($engineers),
                    'title' => 'Mühendisin Randevu Güzergahı'
                );

            break;

            case 'exlist':
                $this->load->library('appointmentsexcellist');
                $this->load->model('AppointmentModel');
                $engineers = $this->AppointmentModel->GetEngineersAsArray($userId);

                $menuData = Array(
                    'content'=> $this->appointmentsexcellist->RouteExList($engineers),
                    'title' => 'Randevu Excel Çıktısı'
                );
            break;

            default:
                $limit = 5;
                $date = date('Y-m-d');
                $this->load->library('appointmentslist');
                $this->load->model('AppointmentModel');
                $appointmentfind = strip_tags(trim($this->input->get('appointmentfind')));
                $page = 1;  
                if(!isset($appointmentfind))
                    $appointmentfind = "";

                $get = $this->AppointmentModel->GetAppointmentEngineer($userId,$date,$page,$appointmentfind);
                $num = $get[1];
                $maxPage = ceil($num / $limit);
                $menuData = Array(
                    'content'=> $this->appointmentslist->DefaultAppointments($get,$maxPage,$page,$appointmentfind),
                    'title' => 'Randevular'
                );
            break;
        }

        $this->load->view("PanelMain",$menuData);
        $this->load->view("PanelFooter");
    }

    
}