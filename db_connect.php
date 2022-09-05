<?php
    try {
        $db = new PDO(
            'mysql:dbname=web-kadai;host=localhost;port=8889;charset=utf8',
            'root',
            'root'
        );
    } catch (PDOException $e) {
        echo "データベースの接続に失敗しました:";
        echo $e->getMessage();
        die();
    }
?>