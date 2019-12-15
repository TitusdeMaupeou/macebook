<?php

include_once 'Model/Post.php';
include_once 'Connection/DatabaseFactory.php';

class PostDAO {

    private static function getConnection() {
        return DatabaseFactory::getDatabase();
    }

     public static function getAllById($id) {
      $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM post WHERE personId=? ORDER BY postId DESC",array($id));
      $resultArray = array();
      for ($index = 0; $index < $result->num_rows; $index++) {
          $databaseRow = $result->fetch_array();
          $new = self::convertRowToObject($databaseRow);
          $resultArray[$index] = $new;
      }
      return $resultArray;
      }

    public static function getAll() {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM post ORDER BY postId DESC"); //de volgorde omkeren, newste eerst
        $resultArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRow = $result->fetch_array();
            $new = self::convertRowToObject($databaseRow);
            $resultArray[$index] = $new;
        }
        return $resultArray;
    }

    public static function getById($id) {
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM post WHERE postId=?", array($id));
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }
    
    public static function getByHighestId() { 
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM post ORDER BY postId DESC LIMIT 1");
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function getByPerson($person) { //om op de profilepagina enkel die person zijn posts te vinden
        $result = self::getConnection()->ExecuteSqlQuery("SELECT * FROM post WHERE personId=?", array($person));
        if ($result->num_rows == 1) {
            $databaseRow = $result->fetch_array();
            return self::convertRowToObject($databaseRow);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function insert($post) {
        return self::getConnection()->ExecuteSqlQuery("INSERT INTO post(personId,time,text) VALUES ('?','?','?')", array($post->getPersonId(), $post->getTime(), $post->getText()));
    }

    public static function deleteById($id) {
        return self::getConnection()->ExecuteSqlQuery("DELETE FROM post where postId=?", array($id));
    }

    public static function deleteByperson($person) {
        return self::getConnection()->ExecuteSqlQuery("DELETE FROM post where personId=?", array($person));
    }

    public static function update($post) {
        return self::getConnection()->ExecuteSqlQuery("UPDATE post SET time='?', text='?' WHERE postId=?", array($post->getTime(), $post->getText()));
    }

    protected static function convertRowToObject($databaseRow) {
        return new Post($databaseRow['postId'], $databaseRow['personId'], $databaseRow['time'], $databaseRow['text']);
    }

}
