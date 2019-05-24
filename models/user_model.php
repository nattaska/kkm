<?php

class User_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserPermmission($user) {

        $sql = "SELECT u.usrcd 'code', u.usrnm name, u.usrnnm nickname, u.usrtel tel, u.usremail email
                     , u.usrrolcd rolcode, r.rolnm rolnm, m.mnuid, m.mnunm, m.mnuurl url
                     , m.mnuicon icon, m.mnulv level, p.pmsauth mnupms
                FROM user u JOIN role r ON u.usrrolcd=r.rolcd
                    JOIN permission p ON u.usrrolcd=p.pmsrolcd
                    JOIN menu m ON p.pmsmnuid=m.mnuid
                WHERE usrcd = :code
                ORDER BY mnusort ";

        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':code'=>$user
        ));
        // $res=$sth->fetch(PDO::FETCH_ASSOC);
        $first = true;

        while($res=$sth->fetch(PDO::FETCH_ASSOC)) {
            if ($first) {
                $this->users["code"] = $res["code"];
                $this->users["name"] = $res["name"];
                $this->users["nickname"] = $res["nickname"];
                $this->users["tel"] = $res["tel"];
                $this->users["email"] = $res["email"];
                $this->users["role"] = $res["rolcode"];
                $this->users["role_name"] = $res["rolnm"];
                $first = false;
            }
            // print_r($res);
            $menu["id"] = $res["mnuid"];
            $menu["name"] = $res["mnunm"];
            $menu["url"] = $res["url"];
            $menu["icon"] = $res["icon"];
            $menu["level"] = $res["level"];
            $this->users[$res["url"]] = $res["mnupms"];

            $this->users["menus"][] = $menu;

            // $menus[]=$menu;
        }
        return $this->users;
    }

    public function xhrSearch() {

        $code = $_POST['usercode'];

        $sql="SELECT u.usrcd code, u.usrnm name, u.usrnnm nickname, u.usrtel phone, 
                        u.usremail email, u.usrrolcd rolecode, r.rolnm rolename
                FROM user u, role r
                WHERE u.usrrolcd=r.rolcd
                AND u.usrcd LIKE '".$code."%' 
                ORDER BY u.usrcd";

        $sth=$this->db->prepare($sql);

        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);

    }

    public function xhrInsert() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $sql = "SELECT CONCAT(SUBSTR(DATE_FORMAT(CURRENT_DATE,'%Y')+543,3,2), 
                                    LPAD(MAX(RIGHT(usrcd,3)+1),3,'0')) nextuser
                    FROM user
                    WHERE usrcd LIKE CONCAT(SUBSTR(DATE_FORMAT(CURRENT_DATE,'%Y')+543,3,2),'%')";

            $row = $this->db->query($sql)->fetch();
            $code = $row["nextuser"];

            $this->db->beginTransaction();

            $sql = "INSERT INTO user VALUE ( :code, MD5(:password), :name, :nickname, :phone, :email, :rolcd) ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':code'=>$code,
                ':password'=>$_POST['phone'],
                ':name'=>$_POST['name'],
                ':nickname'=>$_POST['nickname'],
                ':phone'=>$_POST['phone'],
                ':email'=>$_POST['email'],
                ':rolcd'=>$_POST['rolcd']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error, 'code' => $code);
        echo json_encode($data);
    }

    function xhrUpdate() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  user
                    SET  usrnm  = :name
                        ,usrnnm = :nickname
                        ,usrtel = :phone
                        ,usremail = :email
                        ,usrrolcd = :rolcd
                    WHERE usrcd = :code";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':name'=>$_POST['name'],
                ':nickname'=>$_POST['nickname'],
                ':phone'=>$_POST['phone'],
                ':email'=>$_POST['email'],
                ':rolcd'=>$_POST['rolcd'],
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

    function xhrDelete() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare("DELETE FROM user 
                                        WHERE usrcd = :code ");
            $stmt->execute(array(
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