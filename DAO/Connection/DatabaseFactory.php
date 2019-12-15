<?php
//In deze klasse moet je in principe alleen de connectiegegevens voor jou mysql server aanpassen.
include_once 'Database.php';

class DatabaseFactory {

    //Singleton
    private static $connection;

    public static function getDatabase() {

        if (self::$connection == null) {
            $myComputername = "localhost";
            $myUsername = "BEDev010";
            $myPassword = "39678145";
            $myDatabase = "BEDev010";
            self::$connection = new Database($myComputername, $myUsername, $myPassword, $myDatabase);
        }
        return self::$connection;
    }

}
?>

