<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DefaultPanelAjax extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
   
           
       if ($this->input->is_ajax_request() && $this->session->userdata("login")) {

        
        $userId = $this->session->userdata("id");
        $date = date('Y-m-d');
        $this->load->model('DefaultModel');
        $resultEngineers = $this->DefaultModel->GetEngineersAsArray($userId)->result();

        $table = array();
        $dataQauntity = array();
        $backgroundColor = array();
        $labels = array();

        foreach($resultEngineers as $engineer){
            
            $takeIt = $this->TotalAppointmentsForEngineer($userId,$engineer,$date);
            $dataQauntity[] = $takeIt['total'];
            $color = 'rgb('.rand(0,255).','.rand(0,255).','.rand(0,255).')';
            $backgroundColor[] = $color;
            $labels[] = $takeIt['name'];
            $table[] = Array(
                'name' => $takeIt['name'],
                'bgcolor' => $color,
                'total' => $takeIt['total']
            );
        }

        $listTotal = array();
        foreach ($table as $list) {
            $listTotal[] = $list['total'];
        }
        array_multisort($listTotal, SORT_DESC, $table);

            
        $datasets[] = Array(
            'data' => $dataQauntity,
            'backgroundColor' => $backgroundColor
        );

        $config = Array(
            'type' => 'pie',
            'data' => Array(
                'datasets' => $datasets,
                'labels' => $labels
            ),

            'options' => Array(
                'responsive' => true,
                'legend' => Array(
                    'display' => false
                ),
            )
        );

        $returnedTable = $this->GetChartTable($table);

        $returnedValue = Array(
            'config' => $config,
            'table' => $returnedTable
        );
        echo json_encode($returnedValue);

        }else{
            die("get out there");
        }


    }

    private function TotalAppointmentsForEngineer($userId,$engineer,$date){
        $this->load->model('DefaultModel');
        $appointments = $this->DefaultModel->GetAppointmentsForUserArray($userId,$date,$engineer->id)->result();
        $total = 0;
        foreach($appointments as $app){
            $total += $app->quantity;
        }

        return Array(
            'name' => $engineer->name,
            'total' => $total
        );
    }

    private function GetChartTable($table){

        $returnTable = "";
        foreach($table as $key => $value){
            $returnTable .= '<tr>
                <th scope="row">'.($key+1).'</th>
                <td>
                <svg width="15" height="18">
                    <rect x="0" y="0"  width="10" height="16" style="fill:'.$value['bgcolor'].'" />
                </svg>'.$value['name'].'</td>
                <td>'.$value['total'].'</td>
            </tr>';
        }

        return '<table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Mühendis</th>
            <th scope="col">Kontroller</th>
          </tr>
        </thead>
        <tbody>'.
            $returnTable
        .'</tbody>
      </table>';
    }

}