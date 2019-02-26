<title>Каталог студентів</title>
<link rel="stylesheet" type="text/css" href="styles/style.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css" integrity="2hfp1SzUoho7/TsGGGDaFdsuuDL0LX2hnUp6VkX3CUQ2K4K+xjboZdsXyp4oUHZj" crossorigin="anonymous">
<?php
require_once 'connect/connect.php';
$sql = "SELECT * FROM students ORDER BY last_name ASC";
$i = 0;
?>
<div class="main">
    <div class="page-header clearfix">
        <h2 style="float: left !important;">Каталог студентів</h2>
        <a href="create.php" class="btn btn-success new-stud">Додати нового студента</a>
    </div>
<?php
if($result = mysqli_query($mysqli, $sql)):
    if(mysqli_num_rows($result) > 0): ?>
        <table class="catalog">
            <thead>
            <tr>
                <th>#</th>
                <th>Прізвище</th>
                <th>Ім'я</th>
                <th>Дія</th>
            </tr>
            </thead>
            <tbody>
            <?php while($row = mysqli_fetch_array($result)): ?>
                <tr class="list">
                    <td><?=++$i?></td>
                    <td><?=$row['last_name']?></td>
                    <td><?=$row['first_name']?></td>
                    <td class="actions">
                        <a href="read.php?id=<?=$row['id']?>" title="Переглянути" data-toggle='tooltip'><i class="fas fa-eye first-icon"></i></a>
                        <a href="update.php?id=<?=$row['id']?>" title="Редагувати"><i class="fas fa-edit"></i></a>
                        <a href="delete.php?id=<?=$row['id']?>" title="Видалити"><i class="fas fa-trash-alt last-icon"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php mysqli_free_result($result);
    else: ?>
        <p class='lead'><em>Немає доступних записів.</em></p>
</div>
    <?php endif;
else:
    echo "Помилка $sql. " . mysqli_error($mysqli);
endif;

mysqli_close($mysqli);
?>