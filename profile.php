<?php
if (isset($_COOKIE['UserId'])) { //Testen of de logincookie er is

    include_once 'DAO/PersonDAO.php';
    include_once 'DAO/PostDAO.php';
    
    if (PersonDAO::getById($_COOKIE['UserId']) != false) { //testen of de ID binnen de login cookie bestaat
        $user = PersonDAO::getById($_COOKIE['UserId']); //indien deze bestaat word de ingelogde person in een variabele gestoken
    } else {
        header("Location:login.php");
    }

    if (isset($_GET['profileId'])) { //testen of de GET tag voor de profilelink bestaat

        if (PersonDAO::getById($_GET['profileId']) != false) { //testen of de ID wel bestaat
            $profile = PersonDAO::getById($_GET['profileId']); //zo ja word deze person zijn profile getoont
        } else {
            $profile = $user; //indien niet toont het gewoon je eigen profile
        }
    } else {
        $profile = $user;
    }
} else {
    header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/png" href="img/macebook_favicon.png" />
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>Macebook</title>
        <link rel="stylesheet" type="text/css" href="css/style.css" />

    </head>
    <body>
        <header>
            <div id="headerWrapper">

                <a href="index.php"><img class="logo" src="img/macebook_logo.png"></a>
                <div  class="clearfix" id="headerRechts">

                    <a href="dologout.php" class="clearfix" id="Logout"> <!--logoutknop -->
                        <h1>Logout</h1>
                    </a>

                    <a href="profile.php?profileId=<?php $user->getpersonId(); ?>" class="clearfix"> <!--link naar de ingelogde person zijn profile -->
                        <img src="img/profilephotos/<?php echo $user->getpersonId(); ?>.jpg">
                        <h1><?php echo $user->getLoginname(); ?></h1>
                    </a>

                </div>

            </div>
        </header>
        <main>
            <div id="profileContainer" class="clearfix">
                <img src="img/profilephotos/<?php echo $profile->getpersonId(); ?>.jpg"> <!--profilephoto en alle info van het profile van de profileperson tonen -->
                <div>
                    <h3><?php echo $profile->getLoginname(); ?></h3>
                    <h1><?php echo $profile->getNaam(); ?></h1>
                    <h1><?php echo $profile->getbirthdate(); ?></h1>
                    <h1><?php echo $profile->getgender(); ?></h1>
                    <p><?php echo $profile->getAbout(); ?></p>
                </div>
            </div>
            <ul id="posts">
                <?php
                foreach (PostDao::getAllById($profile->getpersonId()) as $post) { //alle posts van de person tonen met links op de profilephoto en naam
                    $poster = PersonDAO::getById($post->getpersonId());
                    echo '<li class="clearfix">';
                    echo '<a href="profile.php?profileId=' . $poster->getpersonId() . '"><img src="img/profilephotos/'. $poster->getpersonId() . '.jpg"  class="profilephotoKlein"></a>';

                    echo '<div class="clearfix">';
                    echo '<a href="profile.php?profileId=' . $poster->getpersonId() . '"><h1>' . $poster->getLoginname() . '</h1></a>';
                    echo '<h2>' . $post->getTijd() . '</h2>';//de moment dat het gepost werd tonen
                    echo '</div>';

                    echo '<p>'. $post->getText() .'</p>';
                    
                    if (file_exists('img/postPhotos/' . $post->getPostId() . '.jpg')) { //als er bij de post een foto geupload werd toon deze
                        echo '<img src="img/postPhotos/' . $post->getPostId() . '.jpg" class="postPhoto">';
                    }
                    
                    echo '</li>';
                            }
                    ?>
                
            </ul>
        </main>