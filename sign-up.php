<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="kadai-seisaku-css/sign-up.css">
    <title>会員登録画面</title>
</head>
<body>
    <div class="sign_up_form">
        <form action="sign-up.php" method="POST">
            <h1>新規作成</h1>
            
            <div class="input_form">
                <label for="mail_address_id">メールアドレス</label></br>
                <input id="mail_address_id" class="input_form_class" type="text" name="mail_address"></br>

                <label for="new_password_id">パスワード</label></br>
                <input id="new_password_id" class="input_form_class" type="password" name="new_password"></br>

                <label for="re_password_id">パスワード(再入力)</label></br>
                <input id="re_password_id" class="input_form_class" type="password" name="re_password"></br>
                <div class="submit_button">
                    <input type="button" value="登録" onclick="submit()">
                </div>
            </div>

        </form>
        <?php
            require_once('db_connect.php');

            if(isset($_POST["mail_address"] ) && isset($_POST["new_password"]) && isset($_POST["re_password"])){
                if(!empty($_POST)){
                    if($_POST['mail_address'] === ''){
                        $error = 'メールアドレスが入力されていません';
                        echo $error;
                    }

                    if($_POST['new_password'] === ''){
                        $error = 'パスワードが入力されていません';
                        echo $error;
                    }

                    if($_POST['re_password'] === ''){
                        $error = 'パスワード(再入力)が入力されていません';
                        echo $error;
                    }

                    if($_POST['new_password'] !== $_POST['re_password']){
                        $error = 'パスワードが一致していません。';
                        echo $error;
                    }

                    if(!isset($error)){
                        $member = $db->prepare('SELECT COUNT(*) as cnt FROM users WHERE users_name=?');
                        $member->execute(array($_POST['mail_address']));
                        $record = $member->fetch();

                        if($record['cnt'] > 0){
                            $error = 'このメールアドレスは使用できません';
                            echo $error;
                        }else{
                            $sql = $db->prepare("INSERT INTO users(users_name,password) VALUES(:new_mail_address, :new_password)");
                            $sql->bindValue(':new_mail_address',$_POST['mail_address']);
                            $sql->bindValue(':new_password',$_POST['new_password']);
                            $sql->execute();
                            echo "新規登録が完了しました";
                            echo "<br>";
                            echo "<a href='web-page.php'>ページはこちら</a>";
                        }
                    }
                }
            }   

            
        ?>
    </div>
</body>
</html>