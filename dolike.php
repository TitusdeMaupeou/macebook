<?php

if ($_POST['action'] == 'call_this') {
    include_once 'DAO/LikeDAO.php';
    $postId = $_POST['postId'];
    $personId = $_COOKIE['UserId'];
    
    echo '<script language="javascript">';
    echo 'alert("like")';
    echo '</script>';
    
    if (LikeDAO::getLike($postId, $personId) == false) {
        echo '<script language="javascript">';
        echo 'alert("false")';
        echo '</script>';
        LikeDAO::insert(new Like($postId, $personId));
    } else {
        echo '<script language="javascript">';
        echo 'alert("true")';
        echo '</script>';
        LikeDAO::delete($postId, $personId);
    }
}
?>
