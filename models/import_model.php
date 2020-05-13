<?php
include_once('libs/PHPExcel.php');

class Import_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function importOchaSales() {

        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            if (isset($_FILES['file'])) {

                $filename = $_FILES['file']['name'];
                
                if($_FILES["file"]["size"] > 0)
                {
                    move_uploaded_file($_FILES["file"]["tmp_name"],$filename);
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($filename);
                    $excelObj = $excelReader->load($filename);
                    $worksheet = $excelObj->getSheet(0);
                    $lastRow = $worksheet->getHighestRow();

                    // $foundInCells[] = array('เวลาชำระเงิน','เวลารับออเดอร์','เลขที่โต๊ะ / ชื่อ','ยอดบิล','คืนเงิน');
                    $foundInCells = array("หมายเลขอ้างอิง"=>"","เวลาชำระเงิน"=>"","เวลารับออเดอร์"=>"","เลขที่โต๊ะ / ชื่อ"=>"","ยอดบิล"=>"","คืนเงิน"=>"","สถานะ"=>"");
                    $countVal = count($foundInCells);
                    $row = $worksheet->getRowIterator(8)->current();

                    $cellIterator = $row->getCellIterator();
                    $cellIterator->setIterateOnlyExistingCells(true);

                    foreach ($cellIterator as $cell) {
                        if (array_key_exists($cell->getValue(),$foundInCells)) {
                            $foundInCells[$cell->getValue()] = substr($cell->getCoordinate(),0,1);
                            $countVal--;
                        }
                    }
                    if ($countVal == 0) {

                        $sql = "DELETE FROM ocha_sales_import";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute();

                        $sql = "INSERT INTO ocha_sales_import values (:paydate, :ordno, :orddate, :ordnm, :salamt, :salret, :salstat)";
                        $stmt = $this->db->prepare($sql);
                        // echo $file;
                        for ($row = 9; $row <= $lastRow; $row++) {
                            $stmt->execute(array(
                                ':paydate'=>$worksheet->getCell($foundInCells["เวลาชำระเงิน"].$row)->getValue()
                                ,':ordno'=>$worksheet->getCell($foundInCells["หมายเลขอ้างอิง"].$row)->getValue()
                                ,':orddate'=>$worksheet->getCell($foundInCells["เวลารับออเดอร์"].$row)->getValue()
                                ,':ordnm'=>$worksheet->getCell($foundInCells["เลขที่โต๊ะ / ชื่อ"].$row)->getValue()
                                ,':salamt'=>$worksheet->getCell($foundInCells["ยอดบิล"].$row)->getValue()
                                ,':salret'=>$worksheet->getCell($foundInCells["คืนเงิน"].$row)->getValue()
                                ,':salstat'=>$worksheet->getCell($foundInCells["สถานะ"].$row)->getValue()
                            ));
                        }

                        $sql = "DELETE FROM sales_daily
                                WHERE DATE_FORMAT(salorddttm,'%Y-%m-%d') IN (
                                                        SELECT DISTINCT date_format(STR_TO_DATE(isalorddate, '%e/%c/%Y %H:%i'),'%Y-%m-%d') orddate 
                                                        FROM ocha_sales_import)";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute();

                        $sql = "INSERT INTO sales_daily(saldocno, salorddttm, salpaydttm, salordfrom, salordtyp, salamt, salretamt)
                                SELECT isalordno, STR_TO_DATE(isalorddate, '%e/%c/%Y %H:%i') orddate,
                                    STR_TO_DATE(isalpaydate, '%e/%c/%Y %H:%i') paydate,
                                        case when replace(lower(isalordnm),' ','')='foodpanda' then 'Food Panda'
                                            when replace(lower(isalordnm),' ','')='grabfood' then 'Grab Food'
                                            when lower(isalordnm) LIKE '%staff%' then 'Staff'
                                            ELSE isalordnm END ordnm, 
                                        case when replace(lower(isalordnm),' ','')='foodpanda' then 'FPD'
                                            when replace(lower(isalordnm),' ','')='grabfood' then 'GBF'
                                            when isalordnm LIKE 'Room%' then 'NPF'
                                            ELSE 'KKM' END ordtyp,
                                        isalamt, isalret
                                FROM ocha_sales_import
                                WHERE isalstat != 'ยกเลิก' ";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute();

                        $error = $filename;

                    } else {
                        $result = "0";
                        $error = "Data Missing";
                    }
                }

                $this->db->commit();
                unlink($filename);
            } else {
                $result = "0";
                $error = "No upload file";
            }

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);

    }
}

?>