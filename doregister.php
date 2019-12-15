<?php
include_once 'DAO/PersonDAO.php';
if (PersonDAO::getByLoginnaam($_POST["loginnaam"]) == false) {

    $person = new person(0, $_POST["firstname"], $_POST["lastname"], $_POST["loginnaam"], $_POST["password"], $_POST["birthdate"], $_POST["gender"], $_POST["about"]);
    PersonDAO::insert($person);

    $person = PersonDAO::getByHighestId();

    $profilephotoName = $person->getpersonId();
    $profilephoto = $_FILES['profilephoto'];

    move_uploaded_file($profilephoto['tmp_name'], 'img/profilefotos/' . $profilephotoName . '.jpg');

    setcookie('UserId', $person->getpersonId(), time() + 60 * 60 * 24);
    header("location:index.php");
} else {
    header("location:register.php");
}
?>
