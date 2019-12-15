<?php

    include_once 'DAO/PostDAO.php';
    date_default_timezone_set("Europe/Brussels"); //de tijdzone instellen omdat PHP anders een foutmelding geeft
    $post = new Post(0, 0, date("Y-m-d H:i:s"), $_POST["text"]);
    PostDAO::insert($post);

    include_once './validationlibrary.php';

    if (errPhotoCorrect('postPhoto') == "") { //indien er een postPhoto is en deze .jpg is word de code uitgevoert anders gewoon negeren
        $post = PostDAO::getByHighestId(); //laatst aangemaakte post ID vinden
        $postPhotoName = $post->getPostId();
        $postPhoto = $_FILES['postPhoto'];

    //aangezien elke post maar 1 foto kan hebben hernoem ik deze gewoon naar de postID
        move_uploaded_file($postPhoto['tmp_name'], 'img/postPhotos/' . $postPhotoName . '.jpg');
    }
    header("location:index.php");

?>
