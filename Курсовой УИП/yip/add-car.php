<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление авто</title>
    <link rel="stylesheet" href="add-car.css">
</head>
<body>
    <header>
        <h1 >Добавление авто</h1>
    </header>

    <a href="index.php"><input class="knopka" value="На главную"></a>
    <br>
    <br>

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
        <br>
        <input type="file" name="foto" id="foto">
        <br>
        <input type="text" name="desc_sost" placeholder="состояние" id="desc_sost">
        <br></div>

        <div>
            <p>Данные склада</p>
        <input type="text" name="adress" placeholder="адрес" id="adrress">
        </div>

        <div>
            <p>Данные поставщика</p>
        <input type="text" name="name_post" placeholder="название кампании" id="name_post">
        <br>
        <input type="text" name="contact" placeholder="контактное лицо" id="contact">
        <br>
        <input type="text" name="email" placeholder="почта" id="email">
        </div>

        <div>
            <p>Данные поставки</p>
        <input type="text" name="data" placeholder="дата поставки" id="data">
        </div>
        <div><input class="knopka" type="submit" name="Отправить"></div>
    </form>

    <?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['marka'])) {
        echo "<b style='font-size:24px; color:red;'>Введите марку</b>";
    } elseif (empty($_POST['model'])) {
        echo "<b style='font-size:24px; color:red;'>Введите модель</b>";
    } elseif (empty($_POST['color'])) {
        echo "<b style='font-size:24px; color:red;'>Введите цвет</b>";
    } elseif (empty($_POST['year'])) {
        echo "<b style='font-size:24px; color:red;'>Введите год выпуска</b>";
    } elseif (empty($_POST['price'])) {
        echo "<b style='font-size:24px; color:red;'>Введите цену</b>";
    } elseif (empty($_FILES['foto']['name'])) {
        echo "<b style='font-size:24px; color:red;'>Добавьте фото</b>";
    } elseif (empty($_POST['desc_sost'])) {
        echo "<b style='font-size:24px; color:red;'>Введите состояние машины</b>";
    } elseif (empty($_POST['adress'])) {
        echo "<b style='font-size:24px; color:red;'>Введите адрес склада</b>";
    } elseif (empty($_POST['name_post'])) {
        echo "<b style='font-size:24px; color:red;'>Введите название кампании</b>";
    } elseif (empty($_POST['contact'])) {
        echo "<b style='font-size:24px; color:red;'>Введите контактное лицо</b>";
    } elseif (empty($_POST['email'])) {
        echo "<b style='font-size:24px; color:red;'>Введите эл. почту</b>";
    } elseif(!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,8}$/", $_POST['email'])){
        echo "<b style='font-size:24px; color:red; text-align:center;'>Некорректный E-mail, например domain@domain.ru</b>";
    } elseif (empty($_POST['data'])) {
        echo "<b style='font-size:24px; color:red;'>Введите дату поставки</b>";
    } else {
        $marka = htmlspecialchars($_POST['marka']);
        $model = htmlspecialchars($_POST['model']);
        $color = htmlspecialchars($_POST['color']);
        $year = htmlspecialchars($_POST['year']);
        $price = htmlspecialchars($_POST['price']);
        $foto = htmlspecialchars(basename($_FILES['foto']['name']));
        $desc_sost = htmlspecialchars($_POST['desc_sost']);
        $adress = htmlspecialchars($_POST['adress']);
        $name_post = htmlspecialchars($_POST['name_post']);
        $contact = htmlspecialchars($_POST['contact']);
        $email = htmlspecialchars($_POST['email']);
        $data = htmlspecialchars($_POST['data']);
        $id_detail = 0;

        // Загружаем фото на сервер
        $target_dir = "uploads/";
        $target_file = $target_dir . $foto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "Фото успешно загружено. ";
        } else {
            echo "Ошибка при загрузке фото. ";
        }

        // Вставка данных в таблицу Sost
        $sql1 = "INSERT INTO Sost (desc_sost) VALUES ('$desc_sost')";
        if ($mysqli->query($sql1) === true) {
            // Получение последнего вставленного ID из таблицы Sost
            $sost_id = $mysqli->insert_id;

            $sqll = "INSERT INTO Car (`marka`, `model`, `color`, `year`, `price`, `foto`, `id_desc`) VALUES ('$marka', '$model', '$color', '$year', '$price', '$foto', '$sost_id')";
            if ($mysqli->query($sqll) === true) {
                $car_id = $mysqli->insert_id;

                $sql2 = "INSERT INTO Sklad (`adress`) VALUES ('$adress')";
                if ($mysqli->query($sql2) === true) {
                    $sklad_id = $mysqli->insert_id;

                    $sql3 = "INSERT INTO Postavil (`name_post`, `contact`, `email`) VALUES ('$name_post', '$contact', '$email')";
                    if ($mysqli->query($sql3) === true) {
                        $postavil_id = $mysqli->insert_id;

                        $sql4 = "INSERT INTO Postavka (`id_postavil`, `id_car`, `id_detail`, `id_sklad`, `data`) VALUES ('$postavil_id', '$car_id', '$id_detail', '$sklad_id', '$data')";
                        if ($mysqli->query($sql4) === true) {
                            echo "<p style='font-size:24px; color:green;'>Все данные успешно добавлены!</p>";
                            echo "<meta http-equiv='refresh' content='0; URL=add-car.php'>";
                            exit("<b style='font-size:24px; color:green; text-align:center;'>Выполнено!</b>");
                        } else {
                            echo "Ошибка при добавлении данных в таблицу Postavka: " . $mysqli->error; 
                        }
                    } else {
                        echo "Ошибка при добавлении данных в таблицу Postavil: " . $mysqli->error;
                    }
                } else {
                    echo "Ошибка при добавлении данных в таблицу Sklad: " . $mysqli->error;
                }
            } else {
                echo "Ошибка при добавлении данных в таблицу Car: " . $mysqli->error;
            }
        } else {
            echo "Ошибка при добавлении данных в таблицу Sost: " . $mysqli->error;
        }

        $mysqli->close();
    }
}
?>

</body>
</html>