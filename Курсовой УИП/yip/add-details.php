<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление запчастей</title>
    <link rel="stylesheet" href="add-details.css">
</head>
<body>
<header>
        <h1 >Добавление запчастей</h1>
    </header>

    <a href="index.php"><input class="knopka" value="На главную"></a>
    <br>
    <br>

<form class="container" action="" method="post" enctype="multipart/form-data"> 
    
    <div>
        <p>Данные запчасти</p>    
        <input type="text" name="name" placeholder="название" id="name">
        <br>
        <input type="text" name="price" placeholder="цена" id="price">
        <br>
        <input type="file" name="foto" id="foto">
    </div>

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
    if (empty($_POST['name'])) {
        echo "<b style='font-size:24px; color:red;'>Введите название</b>";
    } elseif (empty($_POST['price'])) {
        echo "<b style='font-size:24px; color:red;'>Введите цену</b>";
    } elseif (empty($_FILES['foto']['name'])) {
        echo "<b style='font-size:24px; color:red;'>Добавьте фото</b>";
    } elseif (empty($_POST['adress'])) {
        echo "<b style='font-size:24px; color:red;'>Введите адрес склада</b>";
    } elseif (empty($_POST['name_post'])) {
        echo "<b style='font-size:24px; color:red;'>Введите название кампании</b>";
    } elseif (empty($_POST['contact'])) {
        echo "<b style='font-size:24px; color:red;'>Введите контактное лицо</b>";
    } elseif (empty($_POST['email'])) {
        echo "<b style='font-size:24px; color:red;'>Введите эл. почту</b>";
    } elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,8}$/", $_POST['email'])) {
        echo "<b style='font-size:24px; color:red; text-align:center;'>Некорректный E-mail, например domain@domain.ru</b>";
    } elseif (empty($_POST['data'])) {
        echo "<b style='font-size:24px; color:red;'>Введите дату поставки</b>";
    } else {
        $name = htmlspecialchars($_POST['name']);
        $price = htmlspecialchars($_POST['price']);
        $foto = htmlspecialchars(basename($_FILES['foto']['name']));
        $adress = htmlspecialchars($_POST['adress']);
        $name_post = htmlspecialchars($_POST['name_post']);
        $contact = htmlspecialchars($_POST['contact']);
        $email = htmlspecialchars($_POST['email']);
        $data = htmlspecialchars($_POST['data']);
        $id_car = 0;

        // Загружаем фото на сервер
        $target_dir = "uploads/";
        $target_file = $target_dir . $foto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            echo "Фото успешно загружено. ";
        } else {
            echo "Ошибка при загрузке фото. ";
        }

        $sql1 = "INSERT INTO Details (`name`, `price`, `foto`) VALUES ('$name', '$price', '$foto')";
        if ($mysqli->query($sql1) === true) {
            $detail_id = $mysqli->insert_id;

            // Вставка данных в таблицу Sklad
            $sql2 = "INSERT INTO Sklad (`adress`) VALUES ('$adress')";
            if ($mysqli->query($sql2) === true) {
                $sklad_id = $mysqli->insert_id;

                $sql3 = "INSERT INTO Postavil (`name_post`, `contact`, `email`) VALUES ('$name_post', '$contact', '$email')";
                if ($mysqli->query($sql3) === true) {
                    $postavil_id = $mysqli->insert_id;

                    $sql4 = "INSERT INTO Postavka (`id_postavil`, `id_car`, `id_detail`, `id_sklad`, `data`) VALUES ('$postavil_id', '$id_car', '$detail_id', '$sklad_id', '$data')";
                    if ($mysqli->query($sql4) === true) {
                        echo "<p style='font-size:24px; color:green;'>Все данные успешно добавлены!</p>";
                        echo "<meta http-equiv='refresh' content='0; URL=add-details.php'>";
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
            echo "Ошибка при добавлении данных в таблицу Detail: " . $mysqli->error;
        }
    }

    $mysqli->close();
}
?>

</body>
</html>