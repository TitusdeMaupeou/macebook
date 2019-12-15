<?php
function getFieldVal($nameField) {
    return $_POST[$nameField];
}
//Logische tests
function isFieldEmpty($nameField) {
    $val = getFieldVal($nameField);
    return empty($val);
}
function isFilledIn($nameField1, $nameField2){
    return (!isFieldEmpty($nameField1) || !isFieldEmpty($nameField2));
}
function isFieldGroterDan($nameField, $val) {
    return (getFieldVal($nameField) > $val);
}
function isFieldSmallerOrBigger($nameField, $val) {
    return (getFieldVal($nameField) <= $val);
}
function isFieldNumeriek($nameField) {
    return is_numeric(getFieldVal($nameField));
}
function arePasswordsEqual($password1, $password2){
    return(getFieldVal($password1) === getFieldVal($password2));
}

function isDatumCorrect($datum) {
    $datumArray = explode("-", getFieldVal($datum));
    return ($datumArray[0]>=1850 && $datumArray[0]<=2017 && $datumArray[1]>0 && $datumArray[1]<=12 && $datumArray[2]>0 && $datumArray[2]<=31);
}

function nameExists($nameField) {
    include_once 'DAO/PersonDAO.php';
    if (PersonDAO::getByLoginname(getFieldVal($nameField)) == false){ //checken of de loginname al bestaat
        return false;
    } else {
        return true;
    }
    
}
function photoCorrect($photoField) {
    if (isset($_FILES[$photoField])){ //testen of er een photo geupload is
        $photo = $_FILES[$photoField];
        $file_ext = strtolower(end(explode('.',$photo['name']))); //fileextensie isoleren
    return ($file_ext == 'jpg'); //returnen of de fileextensie .jpg is
    } else {
        return false;
    }
}
//Error message generatie
function errPhotoCorrect($photo){
    if(!photoCorrect($photo)){
        return "Gelieve een photo met .jpg extensie te uploaden";
    }else{
        return "";
    }
}
function errDatumCorrect($datum){
    if(!isDatumCorrect($datum)){
        return "Gelieve een correcte datum in te geven";
    }else{
        return "";
    }
}
function errRequiredField($nameField) {
    if (isFieldEmpty($nameField)) {
        return "Gelieve een val in te geven";
    } else {
        return "";
    }
}
function errOneOfTheseFieldsFilledIn($nameField1, $nameField2){
    if (!isFilledIn($nameField1, $nameField2)){
        return "Gelieve een van deze Fielden in te vullen aub.";
    }
    return "";
}
function errFieldBiggerThanVal($nameField, $val) {
    if (isFieldGroterDan($nameField, $val)) {
        return "";
    } else {
        return "Waarde moet groter zijn dan " . $val . ".";
    }
}
function errFieldSmallerOrBiggerVal($nameField, $val) {
    if (isFieldSmallerOrBigger($nameField, $val)) {
        return "";
    } else {
        return "Waarde moet kleiner dan of gelijk zijn aan " . $val . ".";
    }
}
function errPasswordsNotTheSame($nameField1, $nameField2){
    if(!arePasswordsEqual($nameField1, $nameField2)){
        return "De passworden zijn niet gelijk";
    }
      else{
        return "";  
      }
}
function errNameAlreadyExists($nameField){
    if(nameExists($nameField)) {
        return "Naam is al in gebruik";
    } else{
        return "";
    }
}
function errFieldisNumber($nameField) {
    if (isFieldNumeriek($nameField)) {
        return "";
    } else {
        return "Waarde moet numeriek zijn";
    }
}
function errAddNotification($currentError, $errorToAdd) {
    if (empty($currentError)) {
        return $errorToAdd;
    } else {
        if (empty($errorToAdd)) {
            return $currentError;
        } else {
            return $currentError . "<br>" . $errorToAdd;
        }
    }
}
?>

