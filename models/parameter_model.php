<?php

class Parameter_Model extends Model {
    // public $paramList = array();

    public function __construct() {
        parent::__construct();
    }

    function getParameter($p_tbno, $orderBy = "code") {    
        // $keyword = $_GET['keyword'];

        $sql = "select * 
                from ( select pmdtbno tbno, pmdcd code, pmddesc descp, pmdval1 val1, pmdval2 val2
                        , pmdval3 val3, pmdval4 val4, pmdval5 val5
                from prmdtl 
                where pmdtbno=".$p_tbno.") p
                ORDER BY ".$orderBy;

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        // $this->paramList = $sth->fetchAll();

        return $sth->fetchAll();
    }

    function xhrGetParameterHeaderLov() {

        $sql = "SELECT pmhtbno value, concat(pmhtbno,' - ',pmhdesc) label FROM prmhdr ";

        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function getParameterName($p_tbno) {

        // echo 'SELECT pmhdesc tbname FROM prmhdr WHERE pmhtbno='.$p_tbno;
        $sth = $this->db->prepare('SELECT pmhdesc tbname FROM prmhdr WHERE pmhtbno=:code');
        $sth->bindParam(':code', $p_tbno, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();

        return $sth->fetchAll();
    }

    function xhrGetParameterLov() {
        // $keyword = $_GET['keyword'];

        $p_tbno = $_POST['p_tbno'];

        $sql = "SELECT pmdcd value, concat(pmdcd,' - ',pmddesc) label FROM prmdtl WHERE pmdtbno=".$p_tbno;

        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function xhrGetParameter() {

        $p_tbno = $_POST['p_tbno'];

        $sql = "select pmdcd code, pmddesc descp, pmdval1 val1, pmdval2 val2
                        , pmdval3 val3, pmdval4 val4, pmdval5 val5
                from prmdtl 
                where pmdtbno=".$p_tbno;
                
        $sth=$this->db->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function getParameterGroup($p_grptb, $p_tbno) {    
        // $keyword = $_GET['keyword'];

        $sql = "select t1.pmdcd 'code', t1.pmddesc 'desc', t2.pmdcd 'group', t2.pmddesc 'grpdesc'
                FROM prmdtl t1, prmdtl t2
                WHERE t1.pmdtbno = ".$p_tbno."
                AND t2.pmdtbno = ".$p_grptb."
                AND t1.pmdval1 = t2.pmdcd
                ORDER BY t1.pmdcd";

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        // $this->paramList = $sth->fetchAll();

        return $sth->fetchAll();
    }

    public function xhrInsert() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO prmdtl VALUE( :tbno, :code, :descp, :val1, :val2, :val3, :val4, :val5 )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':tbno'=>$_POST['tbno'],
                ':code'=>$_POST['code'],
                ':descp'=>$_POST['descp'],
                ':val1'=>$_POST['val1'],
                ':val2'=>$_POST['val2'],
                ':val3'=>$_POST['val3'],
                ':val4'=>$_POST['val4'],
                ':val5'=>$_POST['val5']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    function xhrUpdate() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  prmdtl
                    SET  pmddesc  = :descp
                        ,pmdval1 = :val1
                        ,pmdval2 = :val2
                        ,pmdval3 = :val3
                        ,pmdval4 = :val4
                        ,pmdval5 = :val5
                    WHERE pmdtbno = :tbno 
                    AND pmdcd = :code";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':tbno'=>$_POST['tbno'],
                ':code'=>$_POST['code'],
                ':descp'=>$_POST['descp'],
                ':val1'=>$_POST['val1'],
                ':val2'=>$_POST['val2'],
                ':val3'=>$_POST['val3'],
                ':val4'=>$_POST['val4'],
                ':val5'=>$_POST['val5']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    function xhrDelete() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM prmdtl 
                                        WHERE pmdtbno = :tbno 
                                        AND pmdcd = :code ");
            $stmt->execute(array(
                ':tbno'=>$_POST['tbno'],
                ':code'=>$_POST['code']
                ));

            $this->db->commit();

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