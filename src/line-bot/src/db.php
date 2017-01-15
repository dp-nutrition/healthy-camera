<?php
/**
 * Dbに接続する
 * @return PDO
 */
function getDb() {
    $db="sfdc";
    $host="localhost";
    $user="user";//TODO: change user name
    $pass="password";//TODO: change password
    try {
        $dbConnection = new PDO("mysql:host=$host;dbname=$db", $user, $pass,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET `utf8`"));
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        global $app;
        error('データベース接続失敗。:'.$e->getMessage());
        die('データベース接続エラー。');
    }
    return $dbConnection;
}
