<?php

class Person {

    private $personId;
    private $firstname;
    private $lastname;
    private $loginname;
    private $password;
    private $birthdate;
    private $gender;
    private $about;
    
    function getNaam(){
        return $this->firstname . " " . $this->lastname;
    }
            
    function getLoginname() {
        return $this->loginname;
    }

    function setLoginnaam($loginname) {
        $this->loginname = $loginname;
    }

    function getpassword() {
        return $this->password;
    }

    function getbirthdate() {
        return $this->birthdate;
    }

    function getgender() {
        return $this->gender;
    }

    function getAbout() {
        return $this->about;
    }

    function setpassword($password) {
        $this->password = $password;
    }

    function setbirthdate($birthdate) {
        $this->birthdate = $birthdate;
    }

    function setgender($gender) {
        $this->gender = $gender;
    }

    function setAbout($about) {
        $this->about = $about;
    }

    public function getPersonId() {
        return $this->personId;
    }

    public function getfirstname() {
        return $this->firstname;
    }

    public function getlastname() {
        return $this->lastname;
    }

    public function setPersonId($personId) {
        $this->personId = $personId;
    }

    public function setfirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function setlastname($lastname) {
        $this->lastname = $lastname;
    }

    public function __construct($personId, $firstname, $lastname, $loginname, $password, $birthdate, $gender, $about) {
        $this->personId = $personId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->loginname = $loginname;
        $this->password = $password;
        $this->birthdate = $birthdate;
        $this->gender = $gender;
        $this->about = $about;
    }
}
