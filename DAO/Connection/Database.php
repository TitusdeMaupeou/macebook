<?php

class Database {
    protected $computername;
    protected $username;
    protected $password;
    protected $databasename;
    protected $myConnection = null;

    public function __construct($computername, $username, $password, $databasename) {
        $this->computername = $computername;
        $this->username = $username;
        $this->password = $password;
        $this->databasename = $databasename;
    }

    public function __destruct() {
        if ($this->myConnection != null) {
            $this->verbreekVerbindingMetDatabase();
        }
    }

    protected function makeConnectionWithDatabaseDatabase() {
        $this->myConnection = new mysqli($this->computername, $this->username, $this->password, $this->databasename);
        if ($this->myConnection->connect_error) {
            die("Connect Error (" . $this->myConnection->connect_errno . ") " . $this->myConnection->connect_error);
        }
    }

    protected function verbreekVerbindingMetDatabase() {
        if ($this->myConnection != null) {
            $this->myConnection->close();
			$this->myConnection = null;
        }
    }

    protected function preventSqlInjection($parameterWaarde) {
        $result = $this->myConnection->real_escape_string($parameterWaarde);
        return $result;
    }

    public function executeSqlQuery($mySqlQuery, $parameterArray = null) {
        return $this->executeAdvancedQuery($mySqlQuery, true, $parameterArray);
    }

    protected function executeAdvancedQuery($mySqlQuery, $autoDisruptConnection = true, $parameterArray = null) {
        $this->makeConnectionWithDatabaseDatabase();
        if ($parameterArray != null) {
            //Verander alle vraagtekens in de query door parameterVal uit de parameterArray
            $queryParts = preg_split("/\?/", $mySqlQuery);
            if (count($queryParts) != count($parameterArray) + 1) {
                return false;
            }
            $finalQuery = $queryParts[0];
            for ($index = 0; $index < count($parameterArray); $index++) {
                $finalQuery = $finalQuery . $this->preventSqlInjection($parameterArray[$index]) . $queryParts[$index + 1];
            }
            $mySqlQuery = $finalQuery;
        }

        $result = $this->myConnection->query($mySqlQuery);
        if ($autoDisruptConnection) {
            $this->verbreekVerbindingMetDatabase();
        }
        return $result;
    }

}

?>