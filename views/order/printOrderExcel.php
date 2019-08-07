<?php

include_once('libs/PHPExcel/IOFactory.php');

$date = new DateTime();
$fileName = 'orders_'.date_format($date,"YmdHis");

$excelData = $this->items;

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getPageMargins()->setTop(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft(0);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom(0);

// Add column headers
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(21);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
$objPHPExcel->getActiveSheet()->setCellValue('A1',date_format($date,"Y-m-d"));
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('A1:C1');

//Put each record in a new cell
$ii = 0;
for($i=0; $i<count($excelData); $i++){
	$ii = $i+3;
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $excelData[$i]["item"]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $excelData[$i]["qty"]);
}

$ii = $ii+2;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii++, "จ่ายตลาด");
$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii++, "Makro");
$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii++, "รวม");
$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii++, "เบิก");
$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii++, "เหลือ");
$objPHPExcel->getActiveSheet()->getStyle('A'.($ii-5).':A'.$ii)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.($ii-5).':A'.$ii)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

// Set worksheet title
$objPHPExcel->getActiveSheet()->setTitle($fileName);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>