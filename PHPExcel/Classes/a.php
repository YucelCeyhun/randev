<?php
if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
require_once('PHPExcel.php');
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
/*
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'HelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHelloHello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
			
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(200);
			
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
*/
$sharedStyle1 = new PHPExcel_Style();


$sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('argb' => 'FFCCFFCC')
							),
		  'borders' => array(
								'bottom'	=> array('style' => PHPExcel_Style_Border::BORDER_THIN),
								'right'		=> array('style' => PHPExcel_Style_Border::BORDER_MEDIUM)
							),
			'font' => array(
								'bold' => true,
								'color' => array('rgb' => 'FF0000'),
								'size' => 40,
								'name' => 'Georgia'
							)
));
$objPHPExcel->getActiveSheet()->setTitle("CEYHUN");
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, "A1:A5");
for($i=0;$i<30;$i++){
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$i, $i);
}

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="deneme.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$objWriter->save('php://output');

?>