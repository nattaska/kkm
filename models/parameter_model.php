<?php

class Parameter_Model extends Model {
    public $param = array();

    public function __construct() {
        parent::__construct();
    }

    function getParameter($id) {    
        // $keyword = $_GET['keyword'];

        $sql = "select prmcd code, prmdesc descp, prmval1 val1, prmval2 val2
                        , prmval3 val3, prmval4 val4, prmval5 val5
                from parameters 
                where prmid=3 ";

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $this->param = $sth->fetchAll();
    }


}

?>