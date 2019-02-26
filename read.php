<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'connect/connect.php';

    $sql = "SELECT * FROM students WHERE id = ?";

    if($stmt = mysqli_prepare($mysqli, $sql)){
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = trim($_GET["id"]);

        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                $firstName = $row['first_name'];
                $lastName = $row['last_name'];
                $age = $row['age'];
                $university = $row['university'];
            }
            else{
                header("location: error.php");
                exit();
            }
        } else{
            echo "Щось пішло не так:(";
        }
    }

    mysqli_stmt_close($stmt);

    mysqli_close($mysqli);
}
else{
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Інформація про студента</title>
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
                    <h3>Інформація про студента: <?=$row['first_name']?> <?=$row['last_name']?></h3>
                </div>
                <div class="form-group">
                    <label>Ім'я</label>
                    <p class="form-control-static"><?php echo $row['first_name']; ?></p>
                </div>
                <div class="form-group">
                    <label>Прізвище</label>
                    <p class="form-control-static"><?php echo $row['last_name']; ?></p>
                </div>
                <div class="form-group">
                    <label>Вік</label>
                    <p class="form-control-static"><?php echo $row['age']; ?></p>
                </div>
                <div class="form-group">
                    <label>Університет</label>
                    <p class="form-control-static"><?php echo $row['university']; ?></p>
                </div>
                <p><a href="index.php" class="btn btn-primary">Назад</a></p>
            </div>
        </div>
    </div>
</div>
</body>
</html>