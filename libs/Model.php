<?php

class Model {
    function __construct() {
        $this->db = new Database();
        $this->db->query("SET time_zone = '+07:00'");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }
}

?>