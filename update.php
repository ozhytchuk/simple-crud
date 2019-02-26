<?php
require_once 'connect/connect.php';

$firstName = $lastName = $age = $university = "";
$firstName_err = $lastName_err = $age_err = $university_err = "";

if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

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
        $sql = "UPDATE students SET first_name=?, last_name=?, age=?, university=? WHERE id=?";

        if($stmt = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($stmt, "ssisi", $param_firstName, $param_lastName, $param_age, $param_university, $param_id);

            $param_firstName = $firstName;
            $param_lastName = $lastName;
            $param_age = $age;
            $param_university = $university;
            $param_id = $id;

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
} else{
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id =  trim($_GET["id"]);

        $sql = "SELECT * FROM students WHERE id = ?";
        if($stmt = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $firstName = $row['first_name'];
                    $lastName = $row['last_name'];
                    $age = $row['age'];
                    $university = $row['university'];
                } else{
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);

        mysqli_close($mysqli);
    }  else{
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Редагування інформації</title>
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
                    <h2>Редагувати інформацію</h2>
                </div>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($firstName_err)) ? 'has-error' : ''; ?>">
                        <label>Ім'я</label>
                        <input type="text" name="first_name" class="form-control" value="<?php echo $firstName; ?>">
                        <span class="help-block"><?php echo $firstName_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($lastName_err)) ? 'has-error' : ''; ?>">
                        <label>Прізвище</label>
                        <input type="text" name="last_name" class="form-control" value="<?php echo $lastName; ?>">
                        <span class="help-block"><?php echo $lastName_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                        <label>Вік</label>
                        <input type="text" name="age" class="form-control" value="<?php echo $age; ?>">
                        <span class="help-block"><?php echo $age_err;?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($university_err)) ? 'has-error' : ''; ?>">
                        <label>Університет</label>
                        <input type="text" name="university" class="form-control" value="<?php echo $university; ?>">
                        <span class="help-block"><?php echo $university_err;?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                    <input type="submit" class="btn btn-primary" value="Оновити">
                    <a href="index.php" class="btn btn-default">Назад</a>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>