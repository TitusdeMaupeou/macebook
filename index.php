
<?php
/*
if (isset($_COOKIE['UserId'])) {//Testen of de logincookie er is
    include_once 'DAO/PersonDAO.php;

    if (PersonDAO::getById($_COOKIE['UserId']) != false) {//testen of de ID binnen de login cookie bestaat
        $user = PersonDAO::getById($_COOKIE['UserId']);//indien deze bestaat word de ingelogde person in een variabele gestoken
        include_once 'DAO/PostDAO.php';
        //include_once 'DAO/LikeDAO.php';
        date_default_timezone_set("Europe/Brussels");//de tijdzone instellen omdat PHP anders een foutmelding geeft
    } else {
        header("Location:login.php");
    }
} else {
    header("Location:login.php");
}
*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="img/macebook_favicon.png" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Macebook - Home</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

    </head>
    <body>
        <header>
            <div id="headerWrapper">

                <a href="index.php"><img class="logo" src="img/macebook_logo.png"></a>
                <div  class="clearfix" id="headerRechts">

                    <a href="dologout.php" class="clearfix" id="Logout"><!--logoutknop -->
                        <h1>Logout</h1>
                    </a>

                    <a href="img/profilephotos/1.jpg" class="clearfix"><!--link naar de ingelogde person zijn profile -->
                        <img src="img/profilephotos/1.jpg">
                        <h1>Titus de Maupeou</h1> <!-- demonstratie -->
                    </a>

                </div>

            </div>
        </header>
        <main>
            <div id="postForm" class="clearfix">
                <img src="img/profilephotos/1.jpg"> <!--uw profilephoto tonen -->
                <form action="dopost.php" method="POST" id="postFormForm" enctype="multipart/form-data">
                    <textarea name="text" placeholder="What's on your mind, Titus de Maupeou?"></textarea> <!--Facebook nadoen -->
                    <input class="inputfile" id="file" type="file" name="postPhoto">
                    <input type="submit" value="Post" id="postPost">
                    <label for="file">Choose a file</label>
                </form>
            </div>
            <ul id="posts">
                <?php
                foreach (PostDao::getAll() as $post) { //door alle posts loopen en deze in omgekeerd chronologische volgorde zetten
                    $poster = PersonDAO::getById($post->getpersonId()); //de poster in een variabele steken
                    echo '<li class="clearfix">';
                    //links naar het profile van de poster op de naam en de profilephoto aanmaken
                    echo '<a href="profile.php?profileId=1"><img src="img/profilephotos/1.jpg" class="profilephotoKlein"></a>';

                    echo '<div class="clearfix">';
                    echo '<a href="profile.php?profileId=1"><h1><?php ?></h1></a>';
                    echo '<h2>' . date("d/m/Y") . '</h2>'; //de moment dat het gepost werd tonen
                    echo '</div>';

                    echo '<p>Dit is een test.</p>';

                    if (file_exists('img/postPhotos/1.jpg')) {//als er bij de post een foto geupload werd toon deze
                        echo '<img src="img/postPhotos/1.jpg" class="postPhoto">';
                    }
                    
                    echo '</li>';
               }
                ?>

            </ul>
        </main>
    </body>
</html>