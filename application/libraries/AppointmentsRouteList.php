<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AppointmentsRouteList
{

    public function RouteList($engineers){

        
        $engieerList = $this->GetEngineers($engineers);
        
        return '<div id ="appointment-routes">
        <div class="appointment-list">
                <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text far fa-calendar-alt" id="basic-addon1"></span>
                </div>
                    <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Takvim İçin Tıkla">
                    <div class="input-group-append w-50">
                    <select class="custom-select" id="engineers">
                    <option selected value="0">Mühendis Seçin</option>'.
                    $engieerList
                    .'</select>
                    <button type="button" class="btn btn-primary" id="searchButton">Ara</button>
                    </div>
                </div>
        </div>
            <div id="appointment-route-result">
            </div>
        </div>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB9Iu3jWUujPMl3IcNcE1b4sts6JJHkr0s"></script>
        <script type="text/javascript" src="' . base_url('assets/js/appointmentroute.js') . '"></script>';
        

    }

    private function GetEngineers($engineers){
        $returnedValue = "";
        foreach($engineers as $engieer){
           $returnedValue .= '<option value="'.$engieer->id.'">'.$engieer->name.'</option>';
        }
        return $returnedValue;
    }
}
