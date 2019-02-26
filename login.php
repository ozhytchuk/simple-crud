<?php
require_once 'connect/connect.php';
$sql = "SELECT * FROM users";
$login = $password = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputLogin = trim($_POST["login"]);
    if (empty($inputLogin)) {
        $login_err = "Заповніть поле логін.";
    }else {
        $login = $inputLogin;
    }

    $inputPassword = trim($_POST["password"]);
    if (empty($inputPassword)) {
        $password_err = "Заповніть поле пароль.";
    }else {
        $password = $inputPassword;
    }
}

if((!empty($_POST['login'])) && (!empty($_POST['password']))) {
    if ($result = mysqli_query($mysqli, $sql)) {
        while ($row = mysqli_fetch_array($result)) {
            if(($_POST['login'] === $row['username']) && ($_POST['password'] === $row['password'])){
                if($row['role'] === 'admin'){
                    session_start();
                    $_SESSION['admin'] = $row['username'];
                    header('Location: create.php');
                }else{
                    $wrong = 'Ви не є адміністратором сайту';
                }
            }
            else{
                $wrong = 'Невірний логін або пароль';
            }
        }
    }
}
mysqli_close($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Сторінка авторизації</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Введіть свої дані</h2>
                </div>
                <p>Для того, щоб додати нового студента до списку, введіть будь ласка свої дані.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($login_err)) ? 'has-error' : ''; ?>">
                        <label>Логін</label>
                        <input type="text" name="login" class="form-control">
                        <span class="help-block"><?php echo $login_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <label>Пароль</label>
                        <input type="password" name="password" class="form-control">
                        <span class="help-block"><?php echo $password_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Відправити">
                    <a href="index.php" class="btn btn-default">Назад</a>
                </form>
                <?php if(!empty($wrong)): ?>
                    <script>
                        alert('<?=$wrong?>')
                    </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>