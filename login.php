<?php
session_start();

$errors = array();
$username = '';
$email = '';
$password = '';

if (!empty($_POST)) {
    $username = htmlspecialchars($_POST['input_name']);
    $email = htmlspecialchars($_POST['input_email']);
    $password = htmlspecialchars($_POST['input_password']);

    if ($username == ''){
        $errors['username'] = '空';
    }

    if ($email == ''){
        $errors['email'] = '空';
    }

$count = strlen($password);
    if ($password == ''){
        $errors['password'] = '空';
    } elseif ($count < 4 || $count > 16) {
        $errors['password'] = '文字数';
    }


if (empty($errors)) {
    $_SESSION['web_application'] = $_POST;
    header('Location: homepage.php');
    exit();
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
            <!-- <a class="title" href="homepage.html">Home</a> -->
        </header>
        <div class="container">
            <h1 class="theme">ログイン画面</h1>

            
                <div class="section">

        <div class="row">
            <!-- ここから -->
                <div class="col-xs-8 col-xs-offset-2 thumbnail">
                    <h2 class="text-center content_header"></h2>
                    <form method="POST" action="login.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">ユーザー名</label><br>
                            <input type="text" name="input_name" class="form-control" id="name" placeholder="山田 太郎" value="<?php echo $username; ?>" >
                            <?php if (isset($errors['username'])): ?>
                            <span class="danger">ユーザー名を入力してください</span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <input type="email" name="input_email" class="form-control" id="name" placeholder="example@gmail.com" value="<?php echo $email; ?>">
                            <?php if (isset($errors['email'])): ?>
                            <span class="danger">メールアドレスを入力してください</span>
                            <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                            <?php if (isset($errors['password']) && $errors['password'] == '空'): ?>
                                <span class="danger">パスワードを入力してください</span>
                            <?php endif; ?>
                            <?php if (isset($errors['password']) && $errors['password'] == '文字数'): ?>
                                <span class="danger">パスワードは4文字以上16文字以内で入力してください</span>
                            <?php endif; ?>
                        </div>
                        <!-- <div class="form-group">
                            <label for="img_name">プロフィール画像</label>
                            <input type="file" name="input_img_name" id="img_name">
                        </div> -->
                             <input type="submit" style="float: right; padding-top: 6px; margin: 6px;" class="btn btn-primary" value="サインイン">
                    </form>
                </div>
        </div>

    <script src="../assets/js/jquery-3.1.1.js"></script>
    <script src="../assets/js/jquery-migrate-1.4.1.js"></script>
    <script src="../assets/js/bootstrap.js"></script>

                </div><br>
              <!--   <input type="submit" class="btn btn-primary" value="ログイン"> -->
            

        </div>
        <footer class="header">
            <p>毎日ダイアリー</p>
        </footer>
    </div>
</body>

</html>