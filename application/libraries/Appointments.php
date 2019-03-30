<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appointments
{
    private  function SelectResult($data){
        $combinedVal = NULL;
        foreach ($data as $val){
            $combinedVal .='<option value="'.$val->id.'">'.$val->name.'</option>';
        }
        return $combinedVal;
    }

    

    public function CreateAppointmentForm($engineerResult,$companyResult){

        $resultEngineers = $this->SelectResult($engineerResult);
        $resultCompanies = $this->SelectResult($companyResult);

            if(isset($resultCompanies) && isset($resultEngineers)){
            return '<form autocomplete="off">
            <div class="form-group">
                <label for="name">Randevu Tarihi:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text far fa-calendar-alt" id="basic-addon1"></span>
                    </div>
                    <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Takvim İçin Tıkla">
                </div>
            </div>
            <div class="form-group">
                <label for="name">Bina veya Site Adı:</label>
                <input type="text" class="form-control" id="builtname" name="builtname" placeholder="Bina veya Site Adı">
            </div>
            <div class="form-group">
            <label for="companies">Bakımcı Firması:</label>
                <select class="form-control" id="companies" name="companies">'.$resultCompanies.'</select>
            </div>
            <div class="form-group">
                <label for="email">Normal Kontrol Asansör Adedi:</label>
                <div class="text-center mx-auto" id="controlen-scale">0</div>
                <input type="range" class="custom-range" min="0" max="5" step="1" value="0" id="controlen">
            </div>
            <div class="form-group">
                <label for="email">Eksiklik Kontolü Asansör Adedi:</label>
                <div class="text-center mx-auto" id="controlee-scale">0</div>
                <input type="range" class="custom-range" min="0" max="5" step="0.5" value="0" id="controlee">
            </div>
            <div class="form-group">
                <label for="map-address">Map Üzerinden Mühendisin Adresini Belirleyin:</label>
                <button type="button" class="btn btn-primary  btn-block" data-target="#exampleModalCenter" data-toggle="modal" id="selectButton">Adres Seçimi İçin Mapi Görüntüle</button>
                <input type="hidden" id="map-address" name="address" value="">
                <input type="hidden" id="map-address-latlng" name="latlng" value="">
                <input type="hidden" id="neighborhood" name="neighborhood" value="">
                <input type="hidden" id="district" name="district" value="">
            </div>
            <div class="form-group">
            <label for="engineerBtn">En Uygun Mühendisi Belirleyin:</label>
            <button class="btn btn-primary btn-block" type="button" data-toggle="collapse" data-target="#collapseEngineer" aria-expanded="false" aria-controls="collapseEngineer" id="engineerBtn">Mühendisi Belirleyin</button>
            <div class="collapse" id="collapseEngineer">
                <div class="card card-body" id="engineer-select">
                    
                </div>
            </div>
        </div>
            <button type="button" class="btn btn-primary btn-lg mt-5 float-right" id="createBtn">Oluştur</button>
        </form>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <label class="modal-title" id="exampleModalCenterTitle" for="addressfind">Adresi altdan aratabilirsiniz.Dilerseniz map üzerinde tıklayarak işaretleme yapabilirsiniz.</label>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <form class="d-flex mb-3" method="post" action="">
                <input type="text" class="form-control mr-1" id="addressfind" name="addressfind" placeholder="Adres Aratın">
                <button type="button" class="btn btn-primary" id="adressBtn">Ara</button>
            </form>
                <div id="map"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="getMap" data-dismiss="modal">Tamam</button>
            </div>
          </div>
        </div>
      </div>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s&callback=initMap"></script>
      <script type="text/javascript" src="' . base_url('assets/js/appointmentcontrol.js') . '"></script>
      <script type="text/javascript" src="' . base_url('assets/js/createappointmentMap.js') . '"></script>
      <script type="text/javascript" src="' . base_url('assets/js/createappointment.js') . '"></script>';

        }else{
            return 'Randevu oluşturabilmeniz için randevu verebileceğiniz firma ve mühendisin olması gerekiyor';
        }
    }

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
