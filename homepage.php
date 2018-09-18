<?php
session_start();

$dsn = 'mysql:dbname=DiaryApp;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->query('SET NAMES utf8');

$username = $_SESSION['web_application']['input_name'];
$email = $_SESSION['web_application']['input_email'];
$password = $_SESSION['web_application']['input_password'];

$count = strlen($password);

$img_name = $_SESSION['diaryPost']['img_name'];
$date = $_SESSION['diaryPost']['date'];
$text = $_SESSION['diaryPost']['text'];

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';
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
    <link href="homepage.css" rel="stylesheet">
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- <link href="homepage.css" rel="stylesheet"> -->
</head>

<body>
    <div class="wrapper">
        <header class="header">
            <a class="title" href="login.php">ログアウト</a>

            <!-- ハンバーガーメニュー -->
            <div id="nav-drawer">
                <input id="nav-input" type="checkbox" class="nav-unshown">
                <label id="nav-open" for="nav-input"><span></span></label>
                <label class="nav-unshown" id="nav-close" for="nav-input"></label>
                <div id="nav-content">
                <p class="profile-title" style="text-align: center;">☆プロフィール☆</p>
                <ul>
                    <li><?php echo '<span>ユーザーネーム：</span>'.$username; ?></li>
                    <li><?php echo '<span>メールアドレス：</span>'.$email; ?></li>
                    <li><?php 
                    echo '<span>パスワード：</span>';
                    for ($i=0; $i<$count; $i++) {
                      echo '*';
                    } 
                    ?></li>
                </ul>

                <form method="POST" action="post.php">
                  <div style="text-align: center;"><input type="submit" class="btn btn-primary" value="日記を書く"></div>
                </form>

                </div>
            </div>
            <!-- ここまで -->

        </header>
        <div class="container">
            <h1 class="theme"><?php echo $username; ?>'s Diary</h1>

            <form method="POST" action="post.php">
                <div class="section">
                    <div class="col-md-8 content-margin-top">
                        <div class="timeline-centered">

                          <?php
                          $sql = 'SELECT * FROM writing WHERE 1';
                          $stmt = $dbh->prepare($sql);
                          $stmt->execute();
                          $writing = $stmt->fetchAll();

                          ?>

                          <?php foreach ($writing as $write) {  ?>

                            <article class="timeline-entry">
                                <div class="timeline-entry-inner">
                                    <div class="timeline-label">
                                        <div>
                                          <span><?php echo $write['date']; ?></span><br>
                                          <a href="#"><img class="" src="post_img/<?php echo $write['img_name'];?>" alt=""></a><br>
                                          <a href="edit.php?id=<?php echo $write["id"]; ?>" class="btn btn-success" style="color: white">編集</a>
                                          <a href="delete.php?id=<?php echo $write["id"]; ?>" class="btn btn-danger" style="color: white">削除</a>
                                        </div>
                                        <div style="border:0;
                                                    padding:10px;
                                                    font-family:Arial, sans-serif;
                                                    border:solid 1px #ccc;
                                                    margin:0 0 20px;
                                                    width:300px;

                                                    background-color: lightblue;
                                                    text-align: center;

                                                    -webkit-border-radius: 3px;
                                                    -moz-border-radius: 3px;
                                                    border-radius: 3px;
                                                    ">
                                                    <p><?php echo $write['text'];?></p>
                                                  </div>
                                    </div>
                                </div>
                            </article>

                          <?php } ?>
                        </div>
                      </div>
                </div><br>
            </form>

        </div>
        <footer class="header">
            <p>毎日ダイアリー</p>
        </footer>
    </div>
</body>

</html>