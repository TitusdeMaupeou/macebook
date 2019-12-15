<?php

include_once 'Model/Like.php';
include_once 'Connection/DatabaseFactory.php';

class LikeDAO {

    private static function getVerbinding() {
        return DatabaseFactory::getDatabase();
    }

    public static function getAllByPostId($id) {
        $result = self::getVerbinding()->executeSqlQuery("SELECT * FROM like WHERE postId=? ORDER BY personId DESC", array($id));
        $resultatenArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRij = $result->fetch_array();
            $nieuw = self::converteerRijNaarObject($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }

    public static function getAllBypersonId($id) {
        $result = self::getVerbinding()->executeSqlQuery("SELECT * FROM like WHERE personId=? ORDER BY postId DESC", array($id));
        $resultatenArray = array();
        for ($index = 0; $index < $result->num_rows; $index++) {
            $databaseRij = $result->fetch_array();
            $nieuw = self::converteerRijNaarObject($databaseRij);
            $resultatenArray[$index] = $nieuw;
        }
        return $resultatenArray;
    }


        public static function getLike($postId,$personId) {
        $result = self::getVerbinding()->executeSqlQuery("SELECT * FROM like WHERE postId=?, personId=?", array($postId,$personId));
        if ($result->num_rows == 1) {
            $databaseRij = $result->fetch_array();
            return self::converteerRijNaarObject($databaseRij);
        } else {
            //Er is waarschijnlijk iets mis gegaan
            return false;
        }
    }

    public static function insert($like) {
        return self::getVerbinding()->executeSqlQuery("INSERT INTO like(postId,personId) VALUES ('?','?')", array($like->getPostId(), $like->getpersonId()));
    }

    public static function delete($postId, $personId) {
        return self::getVerbinding()->executeSqlQuery("DELETE FROM like WHERE postId=?, personId=?", array($postId, $personId));
    }

    public static function update($post) {
        return self::getVerbinding()->executeSqlQuery("UPDATE post SET tijd='?', text='?' WHERE postId=?", array($post->getTijd(), $post->getText()));
    }

    protected static function converteerRijNaarObject($databaseRij) {
        return new Post($databaseRij['postId'], $databaseRij['personId'], $databaseRij['tijd'], $databaseRij['text']);
    }

}
