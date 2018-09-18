<?php
session_start();

    $dsn = 'mysql:dbname=DiaryApp;host=localhost';
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $dbh->query('SET NAMES utf8');

    // バリデーションの為の空の変数
    $errors = array();
    $text = '';

    if (!empty($_POST)) {

        $date = $_POST['date'];
        $text = htmlspecialchars($_POST['text']);
        $img_name = $_FILES['input_img_name']['name'];

        if ($text == '') {
            $errors['text'] = '空';
        }

        // 画像のバリデーション
        $file_type = substr($img_name, -4);
        $file_type = strtolower($file_type);

        if ($file_type != '.jpg' && $file_type != '.png' && $file_type != '.gif' && $file_type != 'jpeg') {
            $errors['img_name'] = 'type';
        }
        // ここまで

        if (empty($errors)) {
            date_default_timezone_get('Asia/Tokyo');
            $date_str = date('YmdHis');
            $submit_file_name = $date_str.$img_name; // 画像を被らせないようにするため、日付を$img_nameに付け足す

            // move_uploaded_file(テンポラリパス：ファイル名, 保存したい場所)
            move_uploaded_file($_FILES['input_img_name']['tmp_name'], 'post_img/'.$submit_file_name);

            $sql = 'INSERT INTO writing (`date`, `text`, `img_name`) VALUES (?,?,?)';
            $data = array($date, $text, $submit_file_name);
            $stmt = $dbh->prepare($sql);
            $stmt->execute($data);

            $_SESSION['diaryPost'] = $_POST;
            $_SESSION['diaryPost']['img_name'] = $submit_file_name;

            header('Location: homepage.php');
            exit();
            $dbh = null;
        }

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>毎日日記</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .danger{color:red;}
    </style>
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <a class="title" href="login.php">ログアウト</a>
        </header>
        <div class="container">
            <h1 class="theme">編集画面</h1>

            <div class="section">

            <div class="row">
            <!-- ここから -->
                <div class="col-xs-8 col-xs-offset-2 thumbnail">
                    <h2 class="text-center content_header"></h2>

                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="img_name">今日の１枚</label>
                            <input type="file" name="input_img_name" id="img_name" accept="image/*">
                            <?php if (isset($errors['img_name']) && $errors['img_name'] == '拡張子'): ?>
                            <br><span class="danger">画像はjpg, png, gif, jpegを選択してください</span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label for="date">今日の日付</label><br>
                            <input type="date" name="date" class="form-control" id="date" placeholder="山田 太郎">
                        </div>

                        <div class="form-group">
                            <label for="text">今日のふたこと</label>
                            <input type="text" name="text" class="form-control" id="text" placeholder="ふたこと" value="<?php echo $text; ?>">
                            <?php if (isset($errors['text']) && $errors['text'] == '空'): ?>
                            <div style="text-align: center;"><span class="danger">忘れてますよ〜！</span></div>
                        <?php endif; ?>
                        </div>

                        <div style="text-align: center;"><input type="submit" class="btn btn-primary" value="投稿する"></div>
                    </form>
                </div>
            </div>

                </div><br>

        </div>
        <footer class="header">
            <p>毎日日記</p>
        </footer>
    </div>
</body>

</html>