<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запчасти</title>
    <link rel="stylesheet" href="detail.css">
</head>
<body>
    <header>
        <h1>Запчасти</h1>
    </header>

    <a href="index.php"><input type="button" class="knopka" value="На главную"></a>
<hr>

    <?php
    include('connect.php');

    $query = "
        SELECT 
            d.id as detail_id, d.name, d.price, d.foto, 
            sk.adress, p.name_post, p.contact, p.email, ps.data 
        FROM 
            Details d
        JOIN 
            Postavka ps ON d.id = ps.id_detail
        JOIN 
            Sklad sk ON ps.id_sklad = sk.id
        JOIN 
            Postavil p ON ps.id_postavil = p.id";

    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        die('Ошибка выполнения запроса: ' . mysqli_error($mysqli)); // Вывод ошибки, если запрос не удался
    }

    while ($row = mysqli_fetch_array($result)) {
        $detail_id = $row['detail_id'];
        $detail_name = $row['name'];
        $detail_price = $row['price'];
        $detail_photo = $row['foto'];
        $sklad_adress = $row['adress'];
        $postavshik_name = $row['name_post'];
        $postavshik_contact = $row['contact'];
        $postavshik_email = $row['email'];
        $postavka_data = $row['data'];
        echo '
        <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <div style="flex: 1;">
                <img src="uploads/'.$detail_photo.'" alt="'.$detail_name.'" style="margin-left: 50px; width: 300px; height: auto;">
            </div>
            <div style="flex: 2; padding-left: 20px;">
                <h2>'.$detail_name.'</h2>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Цена:</strong> '.$detail_price.' руб.</p>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Адрес склада:</strong> '.$sklad_adress.'</p>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Поставщик:</strong> '.$postavshik_name.'</p>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Контактное лицо:</strong> '.$postavshik_contact.'</p>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Эл. почта:</strong> '.$postavshik_email.'</p>
                <p style="line-height: 1.6; font-size: 16px;"><strong>Дата поставки:</strong> '.$postavka_data.'</p>';


        if (isset($_SESSION['id'])) {
            echo '
                <form method="post" action="">
                    <input type="hidden" name="detail_id" value="'.$detail_id.'">
                    <input type="hidden" name="user_id" value="'.$_SESSION['id'].'">';
if($_SESSION['login'] != 'Admin'){
echo '
                    <input type="submit" name="buy" value="Купить"></form>';
}
if($_SESSION['login'] == 'Admin'){
echo '
            <form method="post"><input type="submit" name="del" value="Удалить"></form><br>
            <form method="post"><input type="submit" name="upd" value="Изменить"></form>';
if (isset($_POST['upd'])) {
    $_SESSION['detailid'] = $detail_id;
echo"<meta http-equiv='refresh' content='0 URL=upd-details.php'>";
}

}
        }

        echo '
            </div>
        </div><hr>';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy'])) {
        $detail_id = $_POST['detail_id'];
        $user_id = $_POST['user_id'];
        $car_id = 0; // ID автомобиля равен 0, так как выбрана только деталь
        $data = date("Y-m-d H:i:s");

        // Вставка данных в таблицу Orders
        $sql = "INSERT INTO Orders (`user_id`, `car_id`, `detail_id`, `data`) VALUES ('$user_id', '$car_id', '$detail_id', '$data')";
        if ($mysqli->query($sql) === true) {
            echo "<p style='font-size: 24px; color: green;'>Заказ успешно добавлен!</p>";
        } else {
            echo "<p style='font-size: 24px; color: red;'>Ошибка при добавлении заказа: " . $mysqli->error . "</p>";
        }
    }
if (isset($_POST['del'])) {
    $detail_id = $_POST['detail_id'];
$sql2 = "DELETE FROM `details` WHERE `details`.`id` LIKE '$detail_id'";
if ($mysqli->query($sql2) === true) {
echo"<meta http-equiv='refresh' content='0 URL=detail.php'>";
}
}

    $mysqli->close();
    ?><hr>

</body>
</html>
