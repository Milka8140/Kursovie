<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автомобили</title>
    <link rel="stylesheet" href="car.css">
</head>
<body>
    <header>
        <h1>Автомобили</h1>
    </header>

    <a href="index.php"><input type="button" class="knopka" value="На главную" ></a>
	<hr>

    <?php 
include ('connect.php');

$query = "
    SELECT 
        c.id as car_id, c.marka, c.model, c.color, c.year, c.price, c.foto,
        s.desc_sost, sk.adress, p.name_post, p.contact, p.email, ps.data 
    FROM 
        Car c
    JOIN 
        Sost s ON c.id_desc = s.id
    JOIN 
        Postavka ps ON c.id = ps.id_car
    JOIN 
        Sklad sk ON ps.id_sklad = sk.id
    JOIN 
        Postavil p ON ps.id_postavil = p.id";

$result = mysqli_query($mysqli, $query);

if (!$result) {
    die('Ошибка выполнения запроса: ' . mysqli_error($mysqli)); // Вывод ошибки, если запрос не удался
}

while ($row = mysqli_fetch_array($result)) {
    $car_id = $row['car_id'];
    $car_marka = $row['marka'];
    $car_model = $row['model'];
    $car_color = $row['color'];
    $car_year = $row['year'];
    $car_price = $row['price'];
    $car_foto = $row['foto'];
    $car_desc_sost = $row['desc_sost'];
    $sklad_adress = $row['adress'];
    $postavshik_name = $row['name_post'];
    $postavshik_contact = $row['contact'];
    $postavshik_email = $row['email'];

echo '
    <div style="display: flex; align-items: center; margin-bottom: 20px;">
        <div style="flex: 1;">
        <br>
        <img src="uploads/'.$car_foto.'" alt="'.$car_marka.'" style="margin-left: 50px;width: 350px; height: auto;">
    
        </div>
        <div style="flex: 2; padding-left: 20px;">
            <br>
            <h2>'.$car_marka.' '.$car_model.'</h2>
            <p style="line-height: 1.6;"><strong>Цвет:</strong> '.$car_color.'</p>
            <p style="line-height: 1.6;"><strong>Год выпуска:</strong> '.$car_year.'</p>
            <p style="line-height: 1.6;"><strong>Цена:</strong> '.$car_price.' руб.</p>
            <p style="line-height: 1.6;"><strong>Состояние:</strong> '.$car_desc_sost.'</p>
            <p style="line-height: 1.6;"><strong>Адрес склада:</strong> '.$sklad_adress.'</p>
            <p style="line-height: 1.6;"><strong>Поставщик:</strong> '.$postavshik_name.'</p>
            <p style="line-height: 1.6;"><strong>Контактное лицо:</strong> '.$postavshik_contact.'</p>
            <p style="line-height: 1.6;"><strong>Эл. почта:</strong> '.$postavshik_email.'</p>';

    if (isset($_SESSION['id'])) {
        echo '
            <form method="post" action="">
                <input type="hidden" name="car_id" value="'.$car_id.'">
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
                $_SESSION['carid'] = $car_id;
                echo"<meta http-equiv='refresh' content='0; URL=upd-car.php'>";
            }
        }
    }

    echo '
        </div>
    </div><hr>';
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy'])) {
    $car_id = $_POST['car_id'];
    $user_id = $_POST['user_id'];
    $detail_id = 0; // ID детали равен 0, так как выбран только автомобиль
    $order_date = date("Y-m-d H:i:s");

    // Вставка данных в таблицу Orders
    $sql = "INSERT INTO Orders (`user_id`, `car_id`, `detail_id`, `data`) VALUES ('$user_id', '$car_id', '$detail_id', '$order_date')";
    if ($mysqli->query($sql) === true) {
        echo "<p style='font-size:24px; color:green;'>Заказ успешно добавлен!</p>";
    } else {
        echo "<p style='font-size:24px; color:red;'>Ошибка при добавлении заказа: " . $mysqli->error . "</p>";
    }
}

if (isset($_POST['del'])) {
    $car_id = $_POST['car_id'];
    $sql2 = "DELETE FROM `car` WHERE `car`.`id` LIKE '$car_id'";
    if ($mysqli->query($sql2) === true) {
        echo"<meta http-equiv='refresh' content='0; URL=car.php'>";
    }
}

$mysqli->close();
?>

<hr>
</body>
</html>
