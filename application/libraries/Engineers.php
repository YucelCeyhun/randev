<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Engineers
{

    private  function UserResult($userResult){
        $allUser = "";
        foreach ($userResult as $user){
            $allUser .='<option value="'.$user->id.'">'.$user->username.'</option>';
        }
        return $allUser;
    }
    public function CreateEnginnerFrom($userResult){

            $result = $this->UserResult($userResult);
        
            return '<form>
            <div class="form-group">
                <label for="name">Mühendisin Adı:</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ad ve Soyad">
            </div>
            <div class="form-group">
                <label for="tel">Cep No:</label>
                <input type="text" class="form-control" id="tel" placeholder="Cep Telefonu Numarası" name="tel" maxlength="10">
            </div>
            <div class="form-group">
                <label for="email">E-Mail Adresi:</label>
                <input type="email" class="form-control" id="engineeremail" placeholder="örnek@domain.com" name="engineeremail">
            </div>
            <div class="form-group">
            <label for="users">Mühendisin Randevucusu(eğer varsa):</label>
                <select class="form-control" id="users" name="users"><option value="0"></option>'.$result.'</select>
            </div>
            <div class="form-group">
            <label for="map-address">Map Üzerinden Mühendisin Adresini Belirleyin:</label>
            <button type="button" class="btn btn-primary  btn-block" data-toggle="modal" data-target="#exampleModalCenter" id="selectButton">Adres Seçimi İçin Mapi Görüntüle</button>
            <input type="hidden" id="map-address" name="address" value="">
            <input type="hidden" id="map-address-latlng" name="latlng" value="">
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
            <div class="d-flex mb-3" method="post" action="">
                <input type="text" class="form-control mr-1" id="addressfind" name="addressfind" placeholder="Adres Aratın">
                <button type="button" class="btn btn-primary" id="adressBtn">Ara</button>
            </div>
                <div id="map"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="getMap" data-dismiss="modal">Tamam</button>
            </div>
          </div>
        </div>
      </div>
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s&callback=initMap"></script>
      <script type="text/javascript" src="' . base_url('assets/js/createengineMap.js') . '"></script>
      <script type="text/javascript" src="' . base_url('assets/js/createngineer.js') . '"></script>';
    }


}

