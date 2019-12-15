<?php

include_once 'DAO/PersonDAO.php';
if (PersonDAO::getByLoginnaam($_POST["loginname"]) != false) { //checken of de loginname bestaat

    $person = PersonDAO::getByLoginnaam($_POST["loginname"]);

    if ($person->getPassword() == $_POST["password"]) { //checken of het password klopt
        setcookie('UsernameId',$person->getpersonId(),time()+60*60*24);
        header("Location:index.php");
    } else {
        header("Location:login.php");
    }
} else {
    header("Location:login.php");
}
?>
