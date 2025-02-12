<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Изменение авто</title>
    <link rel="stylesheet" href="add-car.css">
</head>
<body>
    <header>
        <h1>Изменение авто</h1>
    </header>

    <a href="index.php"><input class="knopka" value="На главную"></a>
    <br><br>

    <form class="container" action="" method="post" enctype="multipart/form-data"> 
        <div>
            <p>Данные атомобиля</p>    
            <input type="text" name="marka" placeholder="марка" id="marka">
            <br>
            <input type="text" name="model" placeholder="модель" id="model">
            <br>
            <input type="text" name="color" placeholder="цвет" id="color">
            <br>
            <input type="text" name="year" placeholder="год выпуска" id="year">
            <br>
            <input type="text" name="price" placeholder="цена" id="price">
            <input type="file" name="foto" id="foto">
            <input class="knopka" type="submit" name="Отправить">
            <br><br>
        </div>
    </form>
<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['marka'])) {
        echo "<b style='font-size: 24px; color: red;'>Введите марку</b>";
    } elseif (empty($_POST['model'])) {
        echo "<b style='font-size: 24px; color: red;'>Введите модель</b>";
    } elseif (empty($_POST['color'])) {
        echo "<b style='font-size: 24px; color: red;'>Введите цвет</b>";
    } elseif (empty($_POST['year'])) {
        echo "<b style='font-size: 24px; color: red;'>Введите год выпуска</b>";
    } elseif (empty($_POST['price'])) {
        echo "<b style='font-size: 24px; color: red;'>Введите цену</b>";
    } elseif (empty($_FILES['foto']['name'])) {
        echo "<b style='font-size: 24px; color: red;'>Добавьте фото</b>";
    } else {
        $marka = htmlspecialchars($_POST['marka']);
        $model = htmlspecialchars($_POST['model']);
        $color = htmlspecialchars($_POST['color']);
        $year = htmlspecialchars($_POST['year']);
        $price = htmlspecialchars($_POST['price']);
        $foto = htmlspecialchars(basename($_FILES['foto']['name']));
        $id_detail = 0;

        // Загружаем фото на сервер

        $target_dir = "uploads/";
        $target_file = $target_dir . $foto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "Фото успешно загружено. ";
        } else {
            echo "Ошибка при загрузке фото. ";
        }

        // Изменение данных в таблице car

        if (isset($_SESSION['carid'])) {
            $car_id = $_SESSION['carid'];

            // Вставка данных в таблицу Car
            $sqll = "UPDATE Car SET marka = '$marka', model= '$model' , color = '$color', year = '$year', price = '$price', foto = '$foto' WHERE `Car`.`id` = '$car_id'";
            if ($mysqli->query($sqll) === true) {
                $car_id = $mysqli->insert_id;
            }
        }
        $mysqli->close();
    }
}
?>
</body>
</html>
