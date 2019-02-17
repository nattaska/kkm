<?php

class Parameter_Model extends Model {
    public $paramList = array();

    public function __construct() {
        parent::__construct();
    }

    function getParameter($id) {    
        // $keyword = $_GET['keyword'];

        $sql = "select prmcd code, prmdesc descp, prmval1 val1, prmval2 val2
                        , prmval3 val3, prmval4 val4, prmval5 val5
                from parameters 
                where prmid=".$id;

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $this->paramList = $sth->fetchAll();
    }

    function xhrGetParameterLov() {
        // $keyword = $_GET['keyword'];

        $id = $_POST['paramId'];

        $sql = "SELECT prmcd value, concat(prmcd,' - ',prmdesc) label FROM parameters WHERE prmid=".$id;

        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function xhrGetParameter() {

        $id = $_POST['paramId'];

        $sql = "select prmcd code, prmdesc descp, prmval1 val1, prmval2 val2
                        , prmval3 val3, prmval4 val4, prmval5 val5
                from parameters 
                where prmid=".$id;
                
        $sth=$this->db->prepare($sql);
        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }


}

?>