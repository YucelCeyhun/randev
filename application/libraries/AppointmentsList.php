<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AppointmentsList
{
    public function DefaultAppointments($get,$maxPage,$currentPage,$appointmentfind){
        $val = $this->GetAllAppointmentsForUser($get);
        $pagination = $this->GetPage($maxPage,$currentPage,$appointmentfind);
        
        return'<div class="appointment-list">
        <form class="'.base_url("panel/appointments/page/").'" method="get" action="'.base_url("panel/appointments/page/").'">
            <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                </div>
                <input type="text" class="form-control mr-1" id="appointmentfind" name="appointmentfind" placeholder="Mühendis veya Bina Ara" autocomplete="off">
                <button type="submit" class="btn btn-primary" id="adressBtn">Ara</button>
             </div>
      
        </form>
        <div class="accordion" id="appointments-accordion">'
        .$val.
        '</div>'.$pagination;
    }

    private function GetAllAppointmentsForUser($get){
        $generalData = "";
        $CI =& get_instance();
        $CI->load->model('AppointmentModel');
        $result = $get[0]->result();
        foreach($result as $list){
            $companyName = $CI->AppointmentModel->GetCompany($list->companyId)->name;
            $generalData .= '
            <div class="card">
            <h5 class="card-header" data-toggle="collapse" data-target="#appointment-'.$list->id.'" aria-expanded="true" aria-controls="collapseOne"><a href="javascript:void(0)">'.$list->builtName.'</a></h5>
            <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Mühendis : </strong>'.$list->name.'</li>
                <li class="list-group-item"><strong>Firma : </strong>'.$companyName.'</li>
                <li class="list-group-item"><strong>Adres : </strong>'.$list->address.'</li>
                '.($list->normalQuantity > 0 ? '<li class="list-group-item"><strong class="text-warning">Normal Kontrol : </strong>'.$list->normalQuantity.' Adet</li>' : null).'
                '.($list->secondQuantity > 0 ? '<li class="list-group-item"><strong class="text-danger">Eksiklik Kontrolü : </strong>'.($list->secondQuantity * 2).' Adet</li>' : null).'

            </ul>
            </div>
            <div id="appointment-'.$list->id.'" class="collapse aria-labelledby="headingOne" data-parent="#appointments-accordion">
                    <div class="collapse-icons ml-auto my-2 mr-2">
                        <a href="'.base_url("panel/appointments/update/").$list->id.'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Düzenle"><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" class="btn btn-primary delete-appointment" data-toggle="tooltip" data-placement="top" title="Sil" id=delete-appointment-'.$list->id.'><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
            ';
        }

        return $generalData;
    }

    private function GetPage($maxPage,$currentPage,$appointmentfind){
        if($currentPage > $maxPage){
            $currentPage = $maxPage;
        }
        
        if($currentPage < 1){
            $currentPage = 1;
        }

        $pageList = "";
        for($i = 1;$i<=$maxPage;$i++){
            $pageList .='<li class="page-item '.($currentPage == $i ? ' active' : null).'">
                <a class="page-link" href="'.base_url('panel/appointments/page/'.$i).($appointmentfind != "" ? '?appointmentfind='.$appointmentfind : null).'" '.($currentPage == $i ? 'aria-current="page" >'.$i.'<span class="sr-only">(current)</span>' : '>'.$i).'</a>
            </li>';
        }

        if($maxPage > 0){
            return '
            <nav aria-label="pages" class="mt-5" id="page-nav">
            <ul class="pagination justify-content-center">
            <li class="page-item'.($currentPage == 1 ? ' disabled' : null).'">
                <a class="page-link" href="'.base_url('panel/appointments/page/'.($currentPage - 1)).($appointmentfind != "" ? '?appointmentfind='.$appointmentfind : null).'"'.($currentPage == 1 ? ' aria-disabled="true"' : null).'>Önceki</a>
            </li>'.
            $pageList
                .'<li class="page-item'.($currentPage == $maxPage || $maxPage == 0 ? ' disabled' : null).'">
                    <a class="page-link" href="'.base_url('panel/appointments/page/'.($currentPage + 1)).($appointmentfind != "" ? '?appointmentfind='.$appointmentfind : null).'"'.($currentPage == $maxPage ? ' aria-disabled="true"' : null).'>Sonraki</a>
                </li>
            </ul>
        </nav>
        </div>
        <script type="text/javascript" src="' . base_url('assets/js/appointmentlist.js') . '"></script>';
        }

        return '';
    }


}
