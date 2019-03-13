<?php

class Parameter_Model extends Model {
    public $paramList = array();

    public function __construct() {
        parent::__construct();
    }

    function getParameter($p_tbno) {    
        // $keyword = $_GET['keyword'];

        $sql = "select pmdcd code, pmddesc descp, pmdval1 val1, pmdval2 val2
                        , pmdval3 val3, pmdval4 val4, pmdval5 val5
                from prmdtl 
                where pmdtbno=".$p_tbno;

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $this->paramList = $sth->fetchAll();
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


}

?>