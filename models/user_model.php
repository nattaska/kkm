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
            $menu["permission"] = $res["mnupms"];

            $this->users["menus"][] = $menu;

            // $menus[]=$menu;
        }
        return $this->users;
    }

}
?>