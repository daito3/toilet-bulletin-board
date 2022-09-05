<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kadai-seisaku-css/web-page.css">
    
    <title>トイレ位置投稿掲示板</title>
</head>
<body>
    <!--
        ユーザーが、自分の知っているトイレの位置を投稿して
        トイレに行きたくて困っている人が、このサイトを使って
        トイレを見つけることが出来る。
    -->
    <div class="header">
        <div class="web_app_name">トイレどこ！？</div>
    </div>
    <div class="header-yohaku"></div>
    <main>
        <!-- ーーーーートイレの位置がわかるMAPーーーーー -->
        <div class="toilet"></div>
        <div class="toilet_map">
            <br>
            <p>トイレの地図とか入れる場所</p>
            <div class="map">
                <img src="img/haribote.png">
            </div>
        </div>
        <!-- ーーーーーー掲示板のところーーーーーーーーー -->
        <div class="bulletin_board">
            <!--  ーーー投稿するところーーーーーーーーー -->
            <div class="bulletin_board_post">
                <a herf="" class="go_to_the_post_form">トイレの位置を投稿しよう</a>

                <form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>">
                    <input type="text" name="place_name"><br><br>
                    <textarea name="contents" value="" rows="4" cols="60"></textarea><br><br>
                    <input type="battom" value="投稿する" onclick="submit()">
                </form>

                <?php
                    session_start();
                    require_once("db_connect.php");

                    if(isset($_POST["place_name"]) && isset($_POST["contents"])){
                        if(!empty($_POST)){
                            if($_POST["place_name"] === ''){
                                $error = '場所が入力されていません';
                                echo $error."<br/>";
                            }
                            if($_POST["contents"] === ''){
                                $error = 'コメントが入力されていません';
                                echo $error."<br/>";
                            }

                            if(!isset($error)){

                                date_default_timezone_set ('Asia/Tokyo');
                                $objDateTime = date('Y-m-d H:i:s');
                                
                                $sql = $db->prepare("INSERT INTO Bulletin_board(name, place, text, time) VALUES(:new_name, :new_place_name, :new_contents, :new_time)");
                                $sql->bindValue(':new_name',$_SESSION['login_user']);
                                $sql->bindValue(':new_place_name',$_POST['place_name']);
                                $sql->bindValue(':new_contents',$_POST['contents']);
                                $sql->bindValue(':new_time', $objDateTime, PDO::PARAM_STR);
                                $sql->execute();
                            }
                        }
                    }  
                    
                    $pdo = null;
                ?>
            </div>
            <!--  ーーー書き込んだやつーーーーーーーーー -->
            <div class="bulletin_board_write_in">
                <?php

                    require_once("db_connect.php");
                
                    $stmts = $db->prepare("SELECT * FROM Bulletin_board");
                    $stmts->execute();
                    
                    while ($stmt = $stmts->fetch()): ?>
                    <br>
                    <?php echo($stmt['text']); ?> 
                    <br>
                    <?php echo('トイレの場所:' . $stmt['place']); ?>
                    <?php echo('　投稿ID:' . $stmt['id']); ?> 
                    <?php echo('　投稿日時：' . $stmt['time']); ?> 
                    <a href="delete.php?id=<?php print($stmt['id']); ?>">削除</a>
                    <br>
                    <hr>
                <?php endwhile; ?>

                <?php
                    $pdo = null;
                ?>
            </div>
        </div>

    </main>
</body>
</html>