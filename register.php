<?php
$readoutfirstname = $readoutlastname = $readoutLoginnaam = $readoutbirthdate = $readoutprofilephoto = $readoutAbout = "";
$errFirstname = $errLastname = $errLoginname = $errPassword = $errPassword2 = $errBirthdate = $errprofilephoto = "";
include_once './validationlibrary.php';
include_once 'DAO/PersonDAO.php';

if (isFormulierIngediend()) {
    $errFirstname = errRequiredField("firstname");
    $errLastname = errRequiredField("lastname");
    $errLoginname = errAddNotification(errRequiredField("loginnaam"), errNameAlreadyExists("loginnaam"));
    $errPassword = errRequiredField("password");
    $errPassword2 = errPasswordsNotTheSame("password", "password2");
    $errBirthdate = errDatumCorrect("birthdate");
    $errprofilephoto = errPhotoCorrect("profilephoto");

    if (isFormulierValid()) {
        $person = new person(0, getFieldVal("firstname"), getFieldVal("lastname"), getFieldVal("loginnaam"), getFieldVal("password"), getFieldVal("birthdate"), getFieldVal("gender"), getFieldVal("about"));
    PersonDAO::insert($person);

    $person = PersonDAO::getByHighestId(); //om de ID aan te roepen van net aangemaakte person moet ik eerst de database checken

    $profilephotoName = $person->getpersonId();
    $profilephoto = $_FILES['profilephoto'];
    
    //ik verplaats de profilephotos naar een aparte folder en hernoem ze naar de ID van de person .jpg aangezien elke person toch maar 1 profilephoto heeft
    move_uploaded_file($profilephoto['tmp_name'], 'img/profilephotos/' . $profilephotoName . '.jpg');

    setcookie('UserId', $person->getpersonId(), time() + 60 * 60 * 24); //cookie aanmaken om in te loggen
    header("location:index.php");
    
    } else {
        $readoutfirstname = getFieldVal("firstname");
        $readoutlastname = getFieldVal("lastname");
        $readoutLoginnaam = getFieldVal("loginnaam");
        $readoutbirthdate = getFieldVal("birthdate");
        $readoutprofilephoto = $_FILES['profilephoto'];
        $readoutgender = getFieldVal("gender");
        $readoutAbout = getFieldVal("about");
        
    }
}

function isFormulierIngediend() {
    return isset($_POST['postcheck']);
}

function isFormulierValid() {
    global $errFirstname, $errLastname, $errLoginname, $errPassword, $errPassword2, $errBirthdate, $errprofilephoto;
    $allErr = $errFirstname . $errLastname . $errLoginname . $errPassword . $errPassword2 . $errBirthdate . $errprofilephoto;
    if (empty($allErr)) {
        //Formulier is valid
        return true;
    } else {
        return false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="img/macebook_favicon.png" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Macebook - Register</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#datepicker").datepicker({
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '1850:2017'
                });
            });
        </script>
    </head>
    <body>
        <header>
            <div id="headerWrapper">

                <a href="index.php"><img class="logo" src="img/macebook_logo.png"></a>
                <div  class="clearfix" id="headerRechts">

                    <a href="login.php" class="clearfix">
                        <h1>Log in</h1>
                    </a>


                </div>

            </div>
        </header>
        <main>
            <form action="register.php" method="POST" id="loginForm" enctype="multipart/form-data">
                <h1>firstname*: </h1><mark><?php echo $errFirstname; ?></mark>
                <input type="text" value="<?php echo $readoutfirstname; ?>" name="firstname" maxlength="20">
                
                <h1>lastname*: </h1><mark><?php echo $errLastname; ?></mark>
                <input type="text" value="<?php echo $readoutlastname; ?>" name="lastname" maxlength="40">
                
                <h1>Loginnaam*: </h1><mark><?php echo $errLoginname;?></mark>
                <input type="text" value="<?php echo $readoutLoginnaam; ?>" name="loginnaam" maxlength="20">
                
                <h1>password*: </h1><mark><?php echo $errPassword; ?></mark>
                <input type="password" name="password" maxlength="20">
                
                <h1>password herhalen*: </h1><mark><?php echo $errPassword2; ?></mark>
                <input type="password" name="password2" maxlength="20">
                
                <h1>birthdate*: </h1><mark><?php echo $errBirthdate; ?></mark>
                <input type="text" value="<?php echo $readoutbirthdate; ?>" id="datepicker" name="birthdate" maxlength="10">
                
                <h1>profilephoto*: </h1><mark><?php echo $errprofilephoto; ?></mark>
                    <input type="file" value="<?php echo $readoutprofilephoto; ?>" name="profilephoto">
                    
                <h1>gender*:</h1>
                <div class="formBlok">
                    <div class="formBlok2 clearfix">
                        <input type="radio" name="gender" value="Man" checked> <h1>Man</h1>
                    </div>
                    <div class="formBlok2 clearfix">
                        <input type="radio" name="gender" value="Vrouw"> <h1>Vrouw</h1>
                    </div>
                </div>
                <h1>Over mezelf:</h1> <!-- Beetje extra info voor op de profilepagina -->
                <textarea name="about"></textarea>
                <input type="hidden" name="postcheck" value="true"/>
                <input type="submit" value="Registreren" class="submit">
            </form>
        </main>
    </body>
</html>