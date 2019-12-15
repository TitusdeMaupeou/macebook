<?php

class Like {

    private $postId;
    private $personId;

    function getPostId() {
        return $this->postId;
    }

    function getpersonId() {
        return $this->personId;
    }

    function setPostId($postId) {
        $this->postId = $postId;
    }

    function setpersonId($personId) {
        $this->personId = $personId;
    }

    function __construct($postId, $personId) {
        $this->postId = $postId;
        $this->personId = $personId;
    }

    //Extra functionaliteit kan je hier schrijven
}
