<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class AppointmentsCreateAuto
{
   
    public function CreateAutoAppointment(){
        return '
            <div class="appointment-excel">
            <div class="card">
            <div class="card-body">
            <form id="get-excel-from">
            <label for="inputAddress">30 Günlük Süre İçinde Aralık Belirleyin:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text far fa-calendar-alt" id="basic-addon1"></span>
                </div>
                <input type="text" class="form-control" id="datepickerFrom" name="datepickerFrom" placeholder="Tarih Aralığı Başlangıcını Belirleyin">
                <input type="text" class="form-control" id="datepickerTo" name="datepickerTo" placeholder="Tarih Aralığı Sonunu Belirleyin">
            </div>
            <label for="inputAddress" class="mt-3">Excel Dosyasını Yükleyin:</label>
            <div class="input-group">
                <input type="file" name="fileexcel" id="fileexcel" class="mt-3" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel">
                <button type="button" class="btn btn-primary" id="uploadBtn">Yükle</button>
                </div>
            <div class="progress mt-3" id="autocreate-progress">
            <span>%0</span>
                <div class="progress-bar" id="excelprogress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
                <button type="button" class="btn btn-primary float-right mt-3" id="createBtn">Oluştur</button>
            </form>
            </div>
            </div>
            </div>
            <script type="text/javascript" src="' . base_url('assets/js/createautoUpload.js') . '"></script>';
    }

}
