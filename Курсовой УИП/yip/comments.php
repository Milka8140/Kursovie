<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>
    <link rel="stylesheet" href="comments.css">
</head>
<body>

<header>
    <h1>Комментарии</h1>  
</header>

<a href="index.php"><input class="knopka" type="button" value="На главную"></a>

<form action="" method="post">
    <p>Введите комментарий<br>
    <textarea style="font-size: 28px;" name="comment" cols="30" rows="4" placeholder="Ваш комментарий"></textarea></p>
    <br>
    <input class="knopka" type="submit" name="Отправить" value="Отправить">
</form>

<?php
include('connect.php');
$user_id = $_SESSION['id'];
$user_log = $_SESSION['login'];
$content = htmlspecialchars($_POST['comment']);
$date = date("d-m-y в H:i");

if (isset($_POST['comment'])) {
    if (!$_SESSION['login'] && !$_SESSION['password']) {
        echo '<br><b><span style="font-size: 24px; color: red;">Войдите, чтобы оставить комментарий.</span></b>';
    } else {
        if (empty($_POST['comment'])) {
            echo '<br><p><span style="font-size: 24px; color: red;">Введите комментарий</span></p>';
        } else {
            $sqll = "INSERT INTO `comments` (`id`, `author_login`, `content`, `data`) VALUES (NULL, '$user_log', '$content', '$date')";
            if ($mysqli->query($sqll) === true) {
                echo "<meta http-equiv='refresh' content='0; URL=comments.php'>";
                exit("<p><center><span style='font-size: 24px; color: green;'>Добавлен!</span></center></p>");
            }
            $mysqli->close();
        }
    }
}

$c = mysqli_query($mysqli, "SELECT * FROM `comments`");
while ($row = mysqli_fetch_array($c)) {
    $id_comm = $row['id'];
    $dat = $row['data'];
    $auth = $row['author_login'];
    $con = $row['content'];
    echo '
    <hr>
    <p style="font-size:24px;"><img src="uploads/UserIco.png" style="width:50px;height:50px;"> ' . $auth . '</p>
    <p style="font-size:24px;">Комментарий: ' . $con . '</p>
    <p style="font-size:24px;">' . $dat . '</p><br>';
    if ($_SESSION['login'] == 'Admin') {
        echo '<form action="" method="post">
        <input type="submit" name="Del-comm" value="Удалить" style="background-color: khaki"></form>
         <br> 
        <hr>';
    }
    if (isset($_POST['Del-comm'])) {
        $sql = "DELETE FROM `comments` WHERE `comments`.`id` = '$id_comm'";
        if ($mysqli->query($sql) === true) {
            echo "<meta http-equiv='refresh' content='0; URL=comments.php'>";
        }
        $mysqli->close();
    }
}
?>
</body>
</html>
