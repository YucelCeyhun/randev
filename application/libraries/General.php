<?php
defined('BASEPATH') or exit('No direct script access allowed');
class General
{
  
    public function GeneralData($engineers,$appointments/*$appointmentsForUser*/)
    {
        return '
            <div class="row">
                <div class="col-lg-6 col-md-12 general-col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                            <div class="col-6">
                            <h5>Mühendisler</h5>
                            <i class="fa fa-users"></i>
                            </div>
                            <div class="col-6">
                            <p style="font-size:6rem">'.$engineers.'</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 general-col">
        <div class="card">
            <div class="card-body">
                <div class="row">
                <div class="col-6">
                <h5>Gidilecek Randevular</h5>
                <i class="fa fa-address-card"></i>
                </div>
                <div class="col-6">
                <p style="font-size:6rem">'.$appointments.'</p>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-12">
    <div class="card">
    <div class="card-header">Mühendis İstatislikleri</div>
        <div class="card-body">
            <div id="chart-wrapper">
            <canvas id="chart-area"></canvas>
            </div>
        </div>
    </div>
    </div>
    <div class="col-lg-6">
    <div class="card" id="chart-table-card">
    <div class="card-header">Gidilecek Kontroller</div>
        <div class="card-body">
            <div id="chart-table">

            </div>
        </div>
    </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="' . base_url('assets/js/panelgeneral.js') . '"></script>
';
    }
}
 