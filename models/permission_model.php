<?php

class Permission_Model extends Model {
    // public $paramList = array();

    public function __construct() {
        parent::__construct();
    }

    function getRole($p_role = "-1") {

        $sql = "SELECT rolcd, rolnm FROM role 
                WHERE ('$p_role' = '-1' OR '$p_role'=rolcd) ";

        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        return $data;
    }

    function xhrSearch() {

        $sql="SELECT mnuid menuid, mnunm menu, ifnull(pmsauth,'N') auth, mnusort sort
                FROM menu LEFT JOIN permission 
                    ON mnuid=pmsmnuid 
                    AND pmsrolcd=:rolecd
                ORDER BY mnusort ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':rolecd', $_POST['rolecd'], PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrSave() {

            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();
            $rolecd = $_POST['rolecd'];
            $auths = $_POST['auths'];

            $del = "DELETE FROM permission WHERE pmsrolcd = :rolecd";
            $stmt = $this->db->prepare($del);
            $stmt->execute(array(
                ':rolecd'=>$rolecd
                ));

            $sql = "INSERT INTO permission (pmsrolcd, pmsmnuid, pmsauth) VALUES (:rolecd, :menuid, :auth) ";
            $stmt = $this->db->prepare($sql);
            for ($i = 0; $i < count($auths); $i++) {
                if ($auths[$i]['auth'] != "N") {
                    echo $auths[$i]['menuid']." : ".$auths[$i]['menu']." : ".$auths[$i]['auth']."</br>";
                    $stmt->execute(array(
                        ':rolecd'=>$rolecd,
                        ':menuid'=>$auths[$i]['menuid'],
                        ':auth'=> $auths[$i]['auth']
                        ));
                }
            }

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