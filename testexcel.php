<?php

include_once('libs/PHPExcel/IOFactory.php');

//set the desired name of the excel file
$fileName = 'create-an-excel-file-in-php';

//prepare the records to be added on the excel file in an array
$excelData = array(
	0 => array('Jackson','Barbara','27','F','Florida'),
	1 => array('Kimball','Andrew','25','M','Texas'),
	2 => array('Baker','John','28','M','Arkansas'),
	3 => array('Gamble','Edward','29','M','Virginia'),
	4 => array('Anderson','Kimberly','23','F','Tennessee'),
	5 => array('Houston','Franchine','25','F','Idaho'),
	6 => array('Franklin','Howard','24','M','California'),
	7 => array('Chen','Dan','26','M','Washington'),
	8 => array('Daniel','Carolyn','27','F','North Carolina'),
	9 => array('Englert','Grant','25','M','Delaware')
);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Me")->setLastModifiedBy("Me")->setTitle("My Excel Sheet")->setSubject("My Excel Sheet")->setDescription("Excel Sheet")->setKeywords("Excel Sheet")->setCategory("Me");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Add column headers
$objPHPExcel->getActiveSheet()
			->setCellValue('A1', 'Last Name')
			->setCellValue('B1', 'First Name')
			->setCellValue('C1', 'Age')
			->setCellValue('D1', 'Sex')
			->setCellValue('E1', 'Location')
			;

//Put each record in a new cell
for($i=0; $i<count($excelData); $i++){
	$ii = $i+2;
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$ii, $excelData[$i][0]);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$ii, $excelData[$i][1]);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$ii, $excelData[$i][2]);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$ii, $excelData[$i][3]);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$ii, $excelData[$i][4]);
}

// Set worksheet title
$objPHPExcel->getActiveSheet()->setTitle($fileName);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>