<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление запчастей</title>
    <link rel="stylesheet" href="add-details.css">
</head>
<body>
    <header>
        <h1>Добавление запчастей</h1>
    </header>

    <a href="index.php"><input class="knopka" value="На главную"></a>
    <br><br>

<form class="container" action="" method="post" enctype="multipart/form-data"> 
    
    <div>
        <p>Данные запчасти</p>    
        <input type="text" name="name" placeholder="название" id="name">
        <br>
        <input type="text" name="price" placeholder="цена" id="price">
        <br>
        <input type="file" name="foto" id="foto">
        <input class="knopka" type="submit" name="Отправить">
        <br><br>
    </div>

</form>

    
    <?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
if (empty($_POST['name'])) {
    echo "<b style='font-size: 24px; color: red;'>Введите название</b>";
} elseif (empty($_POST['price'])) {
    echo "<b style='font-size: 24px; color: red;'>Введите цену</b>";
} elseif (empty($_FILES['foto']['name'])) {
    echo "<b style='font-size: 24px; color: red;'>Добавьте фото</b>";
} else {
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $foto = htmlspecialchars(basename($_FILES['foto']['name']));
    $id_car = 0;

    // Загружаем фото на сервер
    $target_dir = "uploads/";
    $target_file = $target_dir . $foto;
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        echo "Фото успешно загружено. ";
    } else {
        echo "Ошибка при загрузке фото. ";
    }

   if (isset($_SESSION['detailid'])) {
    $detail_id = $_SESSION['detailid'];


            // Вставка данных в таблицу Car
            $sqll = "UPDATE details SET name = '$name', price= '$price' , foto = '$foto' WHERE `details`.`id` LIKE '$detail_id'";
            if ($mysqli->query($sqll) === true) {
                $detail_id = $mysqli->insert_id;
           }

    } 
}

    $mysqli->close();
}

?>

</body>
</html>
