<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kadai-seisaku-css/login.css">
    <title>ログイン画面</title>
</head>
<body>
    <div class="login_form">
        <form action="login.php" method="post">
            <h1>ログイン</h1>

            <div class="input_form">
                <label for="mail_address_id">メールアドレス</label><br>
                <input type="text" name="mail_address" id="mail_address_id" class="input_form_class"><br>

                <label for="password_id">パスワード</label><br>
                <input type="password" name="password" id="password_id" class="input_form_class"><br>
                
                <div class="submit_button">
                    <input type="button" value="ログイン" onclick="submit()">
                </div>
            </div>
        </form>
        <?php
            session_start();
            require_once('db_connect.php');

            if(isset($_POST["mail_address"]) && isset($_POST["password"])){
                if(!empty($_POST)){
                    if($_POST['mail_address'] === ''){
                        $error = 'メールアドレスが入力されていません';
                        echo $error;
                    }

                    if($_POST['password'] === ''){
                        $error = 'パスワードが入力されていません';
                        echo $error;
                    }

                    if(!isset($error)){
                        $member = $db->prepare('SELECT COUNT(*) as cnt1 FROM users WHERE users_name=?');
                        $member->execute(array($_POST['mail_address']));
                        $record_add = $member->fetch();

                        $member = $db->prepare('SELECT COUNT(*) as cnt2 FROM users WHERE password=?');
                        $member->execute(array($_POST['password']));
                        $record_pw = $member->fetch();

                        if(($record_add['cnt1'] > 0) && ($record_pw['cnt2'] > 0)){
                            echo "ログインできました";
                            $_SESSION['login_user'] = $_POST['mail_address'];
                            echo "<br>";
                            echo "<a href='web-page.php'>ページはこちら</a>";
                            echo $_SESSION['login_user'];
                        }else{
                            echo 'ログインが出来ませんでした';
                        }
                    }
                }
            }
        ?>
    </div>
</body>
</html>