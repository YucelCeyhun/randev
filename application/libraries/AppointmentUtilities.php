<?php
defined('BASEPATH') or exit('No direct script access allowed');
class AppointmentUtilities
{
    public function EngineersHomeDistance($engineersDist)
    {

        $tabletr = "";
        foreach ($engineersDist as $key => $value) {
            $tabletr .= '<tr><th>' . ($key + 1) . '</th><td>' . $value['name'] . '</td><td>' . $value['distance'] . ' km</td></tr>';
        }
        $colHome = '<div class="col-xl-3 col-lg-12">
        <div class="card">
        <div class="card-header text-center">
          Ev Mesafesine Göre
        </div>
        <div class="card-body">
        <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Mühendis</th>
            <th scope="col">Ev Mesafesi</th>
          </tr>
        </thead>
        <tbody>' .
            $tabletr
            . '</tbody>
      </table>
        </div>
      </div>
        </div>';

        return $colHome;
    }

    public function EngineersQuantities($engineersQuantity,$total)
    {
        $tabletr = "";
        foreach ($engineersQuantity as $key => $value) {
            if (($value['quantity'] + $total) > 5) {
                $tabletr .= '<tr class="order-not"><th>' . ($key + 1) . '</th><td>' . $value['name'] . '</td><td><div class="progress"><span>' . $value['quantity'] . '/5</span>
                <div class="progress-bar" role="progressbar" style="width:' . ($value['quantity'] / 5 * 100) . '%;" aria-valuenow="' . ($value['quantity'] / 5 * 100) . '" aria-valuemin="0" aria-valuemax="100"></div></div></td></tr>';
            } else {
                $tabletr .= '<tr><th>' . ($key + 1) . '</th><td>' . $value['name'] . '</td><td><div class="progress"><span>' . $value['quantity'] . '/5</span>
                <div class="progress-bar" role="progressbar" style="width:' . ($value['quantity'] / 5 * 100) . '%;" aria-valuenow="' . ($value['quantity'] / 5 * 100) . '" aria-valuemin="0" aria-valuemax="100"></div></div></td></tr>';
            }
        }
        $colQauntity = '<div class="col-xl-3 col-lg-12">
        <div class="card">
        <div class="card-header text-center">
          Randevu Yoğunluğuna Göre
        </div>
        <div class="card-body">
        <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Mühendis</th>
            <th scope="col">Yoğunluk</th>
          </tr>
        </thead>
        <tbody>' .
            $tabletr
            . '</tbody>
      </table>
        </div>
      </div>
        </div>';

        return $colQauntity;
    }

    public function EngineersNearRoutes($engineerNearRoute,$datepicker)
    {

        $CI =& get_instance();
        $CI->load->helper('datefiltertool_helper');
        $date = DateCovert($datepicker);

        $tabletr = "";
        foreach ($engineerNearRoute as $key => $value) {
            $tabletr .= '<tr><th>' . ($key + 1) . '</th><td>' . $value['name'] . '</td><td>' . $value['appointments']['address'] . '</td><td>' . $value['appointments']['distance'] . ' km</td></tr>';
        }

        $emptyQuary = '<div class="col-xl-6 col-lg-12"">
            <div class="card">
                <div class="card-header text-center">
                    Randevu Adresine Göre
                </div>
                <div class="card-body text-center">' .
                  "Randevu verdiğiniz mühendislerin ".$date['d'].' '.$date['m'].' '.$date['y']." tarihinde kontrolü yok."
              . '</div>
            </div>
        </div>';

        $colNearRoute = '<div class="col-xl-6 col-lg-12">
        <div class="card">
        <div class="card-header text-center">
          Randevu Adresine Göre
        </div>
        <div class="card-body">
        <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Mühendis</th>
            <th scope="col">En Yakın Randevu Adresi:</th>
            <th scope="col">Randevu Mesafesi:</th>
          </tr>
        </thead>
        <tbody>' .
            $tabletr
            . '</tbody>
      </table>
        </div>
      </div>
        </div>';

        $tabletr == "" ? $returnedValue = $emptyQuary : $returnedValue = $colNearRoute;

        return $returnedValue;
    }

    public function EngineersQuantitiesEx($EngineersQuantities)
    {
        $selectOpt = "";
        foreach ($EngineersQuantities as $value) {
            $selectOpt .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
        }

        $selectQuantitesEx = '<div class="form-group w-100 m-3">
        <label for="engineers">Uygun Mühendisi Belirleyin:</label>
            <select class="form-control" id="engineers" name="engineers">' . $selectOpt . '</select>
        </div>';

        return $selectQuantitesEx;
    }
}
