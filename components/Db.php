<?php
/*
 * connection for database
 */
class Db{
    public static function getConnection(){
        $db = new PDO('mysql:host=localhost;dbname=comments1', 'root', '');
        $db->exec("set names utf8");
        return $db;
    }
}?>