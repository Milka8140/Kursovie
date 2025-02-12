<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>
    <link rel="stylesheet" href="order.css">
</head>
<?php
if ($_SESSION['login'] != 'Admin') {
    $h_value = "Мои";
}
?>
<body>
    <header>
        <h1><?php echo $h_value; ?> Заказы</h1>
    </header>

    <a href="index.php"><input class="knopka" style="cursor:pointer" value="На главную"></a>
    <br>
    <a href="order.php"><input class="knopka" style="cursor:pointer" value="Обновить"></a>
    <br>
    <br>

    <?php
    include('connect.php');

    if ($mysqli->connect_error) {
        die("Ошибка подключения: " . $mysqli->connect_error);
    }

    if (!isset($_SESSION['id'])) {
        die("Ошибка: данные сессии отсутствуют.");
    }

    $user_id = $_SESSION['id'];

    if ($_SESSION['login'] == 'Admin') {
        $query = "
            SELECT 
                Orders.id AS order_id,
                Users.login AS user_login,
                Car.marka,
                Car.model,
                Details.name AS detail_name,
                Orders.data AS order_date
            FROM Orders
            LEFT JOIN Users ON Orders.user_id = Users.id
            LEFT JOIN Car ON Orders.car_id = Car.id
            LEFT JOIN Details ON Orders.detail_id = Details.id
        ";
    } else {
        $query = "
            SELECT 
                Orders.id AS order_id,
                Users.login AS user_login,
                Car.marka,
                Car.model,
                Details.name AS detail_name,
                Orders.data AS order_date
            FROM Orders
            LEFT JOIN Users ON Orders.user_id = Users.id
            LEFT JOIN Car ON Orders.car_id = Car.id
            LEFT JOIN Details ON Orders.detail_id = Details.id
            WHERE Users.id = '$user_id'
        ";
    }

    $result = $mysqli->query($query);

    if ($result === false) {
        echo "Ошибка выполнения запроса: " . $mysqli->error;
    } elseif ($result->num_rows > 0) {
        echo "<center><table>
                <tr>
                    <th>ID Заказа</th>
                    <th>Логин Пользователя</th>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Наименование детали</th>
                    <th>Дата заказа</th>
                </tr>";

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>
                    <td>{$row['order_id']}</td>
                    <td>{$row['user_login']}</td>
                    <td>{$row['marka']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['detail_name']}</td>
                    <td>{$row['order_date']}</td>";

            if ($_SESSION['login'] == 'Admin') {
                $id_ord = $row['order_id'];
                $user_log = $row['user_login'];
                $mark = $row['marka'];
                $mode = $row['model'];
                $detail = $row['detail_name'];
                echo '<td><form method="POST"><input type="submit" name="del_order" value="Удалить"><input type="hidden" name="ord_id" value="' . $id_ord . '"></form></td><td><form method="POST"><input type="submit" name="of_order" value="Оформить"><input type="hidden" name="ord_id" value="' . $id_ord . '"></form></td></tr>';
            }
        }

        echo "</table></center>";
    } else {
        echo "Нет данных для отображения.";
    }
    if (isset($_POST['del_order'])) {
        $ord_id = $_POST['ord_id'];
        $sql3 = "DELETE FROM `orders` WHERE `orders`.`id` = '$ord_id'";
        if ($mysqli->query($sql3) === true) {
            echo "<meta http-equiv='refresh' content='0; URL=order.php'>";
        }
    }

    if (isset($_POST['of_order'])) {
        $date = date("d-m-y в H:i");
        $ord_id = $_POST['ord_id'];

        $sql1 = "INSERT INTO `sale` (`id`, `id_order`, `id_admin`, `user_login`, `marka`, `model`, `detail_name`, `date`) VALUES (NULL, '$ord_id', 'admin', '$user_log', '$mark', '$mode', '$detail', '$date')";
        if ($mysqli->query($sql1) === true) {
            echo "<p style='font-size: 24px; color: green;'>Продажа оформлена!</p>";
        }

        $sql2 = "DELETE FROM `orders` WHERE `orders`.`id` = '$ord_id'";
        if ($mysqli->query($sql2) === true) {
            echo "<meta http-equiv='refresh' content='0; URL=order.php'>";
        }
    }

    $mysqli->close();
    ?><hr>

</body>
</html>
