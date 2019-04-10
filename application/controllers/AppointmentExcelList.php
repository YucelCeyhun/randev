<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AppointmentExcelList extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper("formtool_helper");
        $this->load->helper("datefiltertool_helper");
    }

    public function index()
    {
           
       if ($this->session->userdata("login") && $this->session->userdata("auth") >= 0 && PHP_SAPI != 'cli') {
        
            $datepickerFrom = StripInput($this->input->post("datepickerFrom"));
            $datepickerTo = StripInput($this->input->post("datepickerTo"));
            $engineers = StripInput($this->input->post("engineers"));


            $this->form_validation->set_message(
                array(
                    "required"      => "Gerekli alanları doldurun",
                    "numeric"       => "{field} harf veya özel karakter içeremez",
                    "DateCheck"     => "{field} uygun değil"
                )
            );

            $this->form_validation->set_rules("datepickerFrom", "Tarih Başlangıcı", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("datepickerTo", "Tarih Sonu", "trim|required|callback_DateCheck");
            $this->form_validation->set_rules("engineers", "Randevu Numarası","trim|required|numeric");
            
            if ($this->form_validation->run())
            {
                $userId = $this->session->userdata("id");
                $datepickerFrom = DateConvertSql($datepickerFrom);
                $datepickerTo = DateConvertSql($datepickerTo);
                $this->ExcelCreate($userId,$datepickerFrom,$datepickerTo,$engineers);
            }else{
                print validation_errors();
            }

        }else{
            die("get out there");
        }

    }

    public function DateCheck($date)
    {
        return DateCalculator($date);
    }

    private function ExcelCreate($userId,$dateFrom,$dateTo,$engineers){
        require_once APPPATH.'third_party/PHPExcel/PHPExcel.php';
        $this->load->model('AppointmentModel');
        $i = 2;
        if($engineers > 0){
            $result = $this->AppointmentModel->GetAppointmentForExcelEx($userId,$dateFrom,$dateTo,$engineers);
        }else{
            $result = $this->AppointmentModel->GetAppointmentForExcel($userId,$dateFrom,$dateTo);
        }

        $objPHPExcel = new PHPExcel();
        $sharedStyle = new PHPExcel_Style();
        $sharedStyle2 = new PHPExcel_Style();

        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
                             ->setCategory("Test result file");

        foreach($result as $list){
            $engineerName = $this->AppointmentModel->GetEngineerName($list->engineerId);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $engineerName);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$i, $list->builtName);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$i, $list->normalQuantity);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, ($list->secondQuantity * 2));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$i, $list->address);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$i, $list->district);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$i, $list->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$i, $list->date);
            $i++;
        }

        $sharedStyle->applyFromArray(
            array('fill' 	=> array(
                'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
                'color'		=> array('argb' => 'f5f9fc')
            ),
            'borders' => array(
                'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
                'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
            ),
            'font' => array(
                'bold' => true,
                'color' => array('rgb' => '495057'),
                'size' => 12,
                'name' => 'Calibri'
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
            ));

            $sharedStyle2->applyFromArray(
                array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
                ));
    
            $objPHPExcel->getActiveSheet()->setTitle("RANDEVU LİSTESİ");
            $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle, "A1:H1");
            $objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle2, "A2:H".$i);

            foreach(range('A','H') as $columnID)
            {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setWidth(20);
            }
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(70);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1',"Mühendis");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1',"Randevu");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1',"Normal Kontrol");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1',"Eksiklik Kontrolü");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1',"Adres");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1',"Belediye");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1',"Firma");
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1',"Tarih");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="randevuList_'.$userId.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        
    }

}