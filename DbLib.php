<?php
require( dirname(__FILE__). '/BaseDbLib.php');

class DbLib extends BaseDbLib
{

    public function getUsers()
    {
        //データベース接続処理
        $dbh = $this->connectDb();
        
        $sql = "SELECT * FROM users";
        $stmt = $dbh->prepare($sql);
        //$stmt->bindValue(':user_mail', $user_mail, PDO::PARAM_STR);
        $stmt->execute();
        
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        //データベース切断処理
        $this->disconnectDb($stmt, $dbh);
        
        return $users;
    }
    public function insertUser($userName){

        //データベース接続処理
        $dbh = $this->connectDb();

        $sql = 'INSERT INTO users
             (name, left_X, top_Y)
             VALUES (:userName, 10, 10)';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
        $stmt->execute();

        //データベース切断処理
        $this->disconnectDb($stmt, $dbh);
        
    }
    public function updateUser($id, $left, $top){

        //データベース接続処理
        $dbh = $this->connectDb();

        $sql = 'UPDATE users
         SET left_X = :left, top_Y = :top
        WHERE id = :id';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':left', $left, PDO::PARAM_STR);
        $stmt->bindValue(':top', $top, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);
        $stmt->execute();

        //データベース切断処理
        $this->disconnectDb($stmt, $dbh);
        
    }
}

