<?php
include_once 'Model/Person.php';
include_once 'Connection/DatabaseFactory.php';

class PersonDAO {

    private static function getConnection() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAll() {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM person");
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $new = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $new;
        }
        return $resultArray;
    }

    public static function getAllByFirstname($firstname) {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM person WHERE firstname='?'", array($firstname));
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $new = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $new;
        }
        return $resultArray;
    }

    public static function getById($id) {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM person WHERE personId=?", array($id));
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }
    
    public static function getByLoginname($loginname) {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM person WHERE loginname='?'", array($loginname));
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }
    
    public static function getByHighestId() { //Vindt laatst aangemaakte row in database
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM person ORDER BY personId DESC LIMIT 1");
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function insert($person) {
        return self::getConnection()->ExecuteSqlQuery("INSERT INTO person(firstname, lastname, loginname, password, birthdate, gender, about) VALUES ('?','?','?','?','?','?','?')", 
                array($person->getFirstname(), $person->getLastname(), $person->getLoginname(), $person->getPassword(), $person->getBirthdate(), $person->getGender(), $person->getAbout()));
        
    }

    public static function deleteById($id) {
        return self::getConnection()->ExecuteSqlQuery("DELETE FROM person where personId=?", array($id));
    }

    public static function delete($person) {
        return self::deleteById($person->getpersonId());
    }

    public static function update($person) {
        return self::getConnection()->ExecuteSqlQuery("UPDATE person SET firstname='?',lastname='?',loginname='?',password='?',birthdate='?',gender='?',about='?' WHERE personId=?", array($person->getFirstname(), $person->getLastname(), $person->getLoginname(), $person->getPassword(), $person->getBirthdate(), $person->getGender(), $person->getAbout(), $person->getpersonId()));
    }

    protected static function convertRowToObject($databaseRow) {
        return new person($databaseRow['personId'], $databaseRow['firstname'], $databaseRow['lastname'], $databaseRow['loginname'], $databaseRow['password'], $databaseRow['birthdate'], $databaseRow['gender'], $databaseRow['about']);
    }

}
