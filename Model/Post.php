<?php

class Post {

    private $postId;
    private $personId;
    private $tijd;
    private $text;

    function getTijd() {
        return $this->tijd;
    }

    function setTijd($tijd) {
        $this->tijd = $tijd;
    }

    function getPostId() {
        return $this->postId;
    }

    function getpersonId() {
        return $this->personId;
    }

    function getText() {
        return $this->text;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setpersonId($personId) {
        $this->personId = $personId;
    }

    function setText($text) {
        $this->text = $text;
    }

    function __construct($postId, $personId, $tijd, $text) {
        $this->postId = $postId;
        $this->personId = $personId;
        $this->tijd = $tijd;
        $this->text = $text;
    }

    //Extra functionaliteit kan je hier schrijven
}
