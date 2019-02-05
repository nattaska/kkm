<?php

class Employee extends Model {
    public code;
    public password; 
    public fname;
    public lname;
    public nname;
    public phone;
    public profile;
    // Payment
    
    public deptcd;
    public paytype;
    public paymethd;
    public account;

    public function __construct() {
        parent::__construct();
    }

    public getEmployee($code) {
        $sql="";
    }
}

?>