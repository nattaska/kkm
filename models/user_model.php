<?php

class User_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getUserPermmission($user) {

        $sql = "SELECT u.usrcd 'code', u.usrnm name, u.usrnnm nickname, u.usrtel tel, u.usremail email, 
                        u.usrrolcd rolecode, p.pmsauth authen, mnuid, mnunm, mnuurl
                FROM user u JOIN permission p ON u.usrrolcd=p.pmsrolcd
                    JOIN menu m ON p.pmsmnuid=m.mnuid
                WHERE usrcd = :code
                ORDER BY mnusort ";

        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':code'=>$user
        ));
        $this->users=$sth->fetch(PDO::FETCH_ASSOC);

        // while($res=$sth->fetch(PDO::FETCH_ASSOC)) {
        //     print_r($res);
        //     $this->users[]=$res;
        // }
        return $this->users;
    }

}
?>