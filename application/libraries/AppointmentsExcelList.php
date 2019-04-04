<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AppointmentsExcelList
{

    public function RouteExList($engineers){

        $engieerList = $this->GetEngineers($engineers);

        return '
            <div class="appointment-excel">
            <div class="card">
            <div class="card-body">
            <form action="/AppointmentExcelList/" method="post" id="get-excel-from">
            <label for="inputAddress">30 Günlük Süre İçinde Aralık Belirleyin:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text far fa-calendar-alt" id="basic-addon1"></span>
                </div>
                <input type="text" class="form-control" id="datepickerFrom" name="datepickerFrom" placeholder="Tarih Aralığı Başlangıcını Belirleyin">
                <input type="text" class="form-control" id="datepickerTo" name="datepickerTo" placeholder="Tarih Aralığı Sonunu Belirleyin">
            </div>
                <div class="form-group mt-4">
                <label for="inputAddress">Mühendis Seçebilirsininz:</label>
                <select class="custom-select" id="engineers" name="engineers">
                <option selected value="0">Tüm Mühendisler</option>'.
                $engieerList
                .'</select>
              </div>
                <button type="button" class="btn btn-primary float-right" id="createBtn">Oluştur</button>
            </form>
            </div>
            </div>
            </div>
            <script type="text/javascript" src="' . base_url('assets/js/appointmentexcel.js') . '"></script>';
        


    }

    
    private function GetEngineers($engineers){
        $returnedValue = "";
        foreach($engineers as $engieer){
           $returnedValue .= '<option value="'.$engieer->id.'">'.$engieer->name.'</option>';
        }
        return $returnedValue;
    }

}
