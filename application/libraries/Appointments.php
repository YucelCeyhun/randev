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

}
