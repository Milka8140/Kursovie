<?php session_start();
if($_SESSION['login'] != 'Admin'){
	$header = "Покупки";
}
else{
	$header = "Продажи";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Продажи</title>
    <link rel="stylesheet" href="sale.css">
</head>
<body>
    <header>
        <h1><? echo $header;?></h1>
    </header>
    <a href="index.php"><input  class="knopka"  value="На главную"></a>
    <br>
    <?php
// Подключение к базе данных
include('connect.php');

// Проверка подключения
if ($mysqli->connect_error) {
    die("Ошибка подключения: " . $mysqli->connect_error);
}
if($_SESSION['login'] == 'Admin'){

// Запрос для получения данных
$sql = "
    SELECT * FROM sale";

// Выполнение запроса
$result = $mysqli->query($sql);

// Проверка результатов
if ($result->num_rows > 0) {
    echo "<center><table border='1'>
            <tr>
                <th>ID</th>
		        <th>ID Продажи</th>
                <th>Сотрудник</th>
                <th>Пользователь</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Деталь</th>
                <th>Дата</th>
            </tr>";
    
    // Вывод данных в виде таблицы
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['id_order']}</td>
		        <td>{$row['id_admin']}</td>
                <td>{$row['user_login']}</td>
                <td>{$row['marka']}</td>
                <td>{$row['model']}</td>
                <td>{$row['detail_name']}</td>
		        <td>{$row['date']}</td>
            </tr>";
    }
    
    echo "</table></center>";
} else {
    echo "Нет данных для отображения.";
}
}

if($_SESSION['login'] != 'Admin'){
	$user = $_SESSION['login'];
	$sql = "SELECT * FROM sale WHERE `user_login` = '$user'";

// Выполнение запроса
$result = $mysqli->query($sql);

// Проверка результатов
if ($result->num_rows > 0) {
    echo "<center><table border='1'>
            <tr>
                <th>ID</th>
		        <th>ID Продажи</th>
                <th>Сотрудник</th>
                <th>Пользователь</th>
                <th>Марка</th>
                <th>Модель</th>
                <th>Деталь</th>
                <th>Дата</th>
            </tr>";
    
    // Вывод данных в виде таблицы
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['id_order']}</td>
	        	<td>{$row['id_admin']}</td>
                <td>{$row['user_login']}</td>
                <td>{$row['marka']}</td>
                <td>{$row['model']}</td>
                <td>{$row['detail_name']}</td>
			<td>{$row['date']}</td>
            </tr>";
    }
    
    echo "</table></center>";
} else {
    echo "Нет данных для отображения.";
}
}

// Закрытие соединения
$mysqli->close();
?><hr>

</body>
</html>