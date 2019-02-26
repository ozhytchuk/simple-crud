<?php
require_once 'connect/connect.php';
session_start();
if(isset($_POST['do']) && $_POST['do'] == 'logout'){
    unset($_SESSION['admin']);
}

if(!isset($_SESSION['admin'])):
    header('Location: login.php');
else:
$firstName = $lastName = $age = $university = "";
$firstName_err = $lastName_err = $age_err = $university_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $input_firstName = trim($_POST["first_name"]);
    if(empty($input_firstName)){
        $firstName_err = "Будь ласка введіть ім'я.";
    } else{
        $firstName = $input_firstName;
    }

    $input_lastName = trim($_POST["last_name"]);
    if(empty($input_lastName)){
        $lastName_err = "Будь ласка введіть прізвище.";
    } else{
        $lastName = $input_lastName;
    }

    $input_age = trim($_POST["age"]);
    if(empty($input_age)){
        $age_err = "Будь ласка введіть вік.";
    } elseif(!ctype_digit($input_age)){
        $age_err = "Будь ласка введіть ціле число(не рядок).";
    } else{
        $age = $input_age;
    }

    $input_university = trim($_POST["university"]);
    if(empty($input_university)){
        $university_err = "Будь ласка введіть назву університету.";
    } else{
        $university = $input_university;
    }

    if(empty($firstName_err) && empty($lastName_err) && empty($age_err) && empty($university_err)){
        $sql = "INSERT INTO students (first_name, last_name, age, university) VALUES (?, ?, ?, ?)";
        if($stmt = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($stmt, "ssis", $param_firstName, $param_lastName, $param_age, $param_university);

            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_age = $age;
            $param_university = $university;

            if(mysqli_stmt_execute($stmt)){
                header("location: index.php");
                exit();
            } else{
                echo "Щось пішло не так:(";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Додати нового студента</title>
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
                    <h2>Додати нового студента</h2>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                        <label>Ім'я</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo $firstName; ?>" autocomplete="off">
                        <span class="help-block"><?php echo $firstName_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                        <label>Прізвище</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo $lastName; ?>" autocomplete="off">
                        <span class="help-block"><?php echo $lastName_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                        <label>Вік</label>
                        <input type="text" name="age" class="form-control" value="<?php echo $age; ?>" autocomplete="off">
                        <span class="help-block"><?php echo $age_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($university_err)) ? 'has-error' : ''; ?>">
                        <label>Університет</label>
                        <input type="text" name="university" class="form-control" value="<?php echo $university; ?>" autocomplete="off">
                        <span class="help-block"><?php echo $university_err;?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Відправити">
                    <a href="index.php" class="btn btn-default">Назад</a>
                    <a href="login.php?do=exit" class="btn btn-default" style="float: right !important;">Вийти</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php endif; ?>