<?php
if (isset($_COOKIE["UserId"])){
    include_once 'DAO/PersonDAO.php';
    
    if (PersonDAO::getById($_COOKIE['UserId']) != false) {
        header("Location:index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="img/macebook_favicon.png" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Login - Macebook</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

    </head>
    <body>
    <header>
        <div id="headerWrapper">
            
            <a href="index.php"><img class="logo" src="img/macebook_logo.png"></a>
                <div  class="clearfix" id="headerRechts">
                    
                    <a href="register.php" class="clearfix">
                        <h1>Registreer</h1>
                    </a>

            
            </div>
            
            </div>
        </header>
        <main>
            <form action="dologin.php" method="POST" id="loginForm">
                <h1>Name</h1>
                <input type="text" name="loginnaam">
                <h1>Password</h1>
                <input type="password" name="password">
                <input type="submit" value="Inloggen" class="submit">
            </form>
        </main>
    </body>
</html>