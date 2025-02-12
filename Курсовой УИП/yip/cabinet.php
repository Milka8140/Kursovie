<?php
session_start();
include('connect.php');

$login = $_SESSION['login'];

// Проверка, существует ли логин в таблице Admin
$sql_check_admin = "SELECT * FROM Admin WHERE login ='$login'";
$result_check_admin = $mysqli->query($sql_check_admin);

$is_admin = false;
if ($result_check_admin) {
   // echo '<p>Запрос к таблице Admin выполнен успешно</p>';
    if ($result_check_admin->num_rows == 1) {
        $is_admin = true;
       // echo '<p>Пользователь найден в таблице Admin</p>';
    } else {
        //echo '<p>Пользователь не найден в таблице Admin</p>';
    }
} else {
    echo '<p>Ошибка в запросе к таблице Admin: ' . $mysqli->error . '</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабинет</title>
    <link rel="stylesheet" href="cabinet.css">
</head>
<body>
    <header>
        <h1>Личный кабинет</h1>
    </header>

	<?
    if($_SESSION['login'] != 'Admin'){
	$btn_value = "Мои";
	$btn_value2 = "Покупки";
    }?>
    
    <a href="index.php"><input  class="knopka"  value="На главную"></a>
    <br>
    <a href="order.php"><input class="knopka"  value='<?echo $btn_value;?> Заказы'></a>
    <br>

    <?php
    // Показываем кнопки добавления только для Admin
    if ($is_admin){
        echo '<a href="add-car.php"><input class="knopka" value="Добавить авто"></a>';
        echo '<br>';
        echo '<a href="add-details.php"><input class="knopka"  value="Добавить запчасть"></a>';
        echo '<br>';
	$btn_value2 = "Продажи";
        

    }
echo '<a href="sale.php"><input class="knopka"  value='.$btn_value2.'></a>';
    ?><hr>
</body>
</html>
