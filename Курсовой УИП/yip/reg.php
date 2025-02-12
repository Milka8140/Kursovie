<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="Signupp.css">
</head>
<body>

<div class="wrapper">
    <div class="title"><span>Регистрация</span></div>
    <form action="" method="post">
      <div class="row">
        <i class="fas fa-user"><img src='uploads/SignIn/Login.png'/></i>
        <input type="text" name="login" placeholder="Логин" id="login" >
      </div>
      <div class="row">
        <i class="fas fa-user"><img src='uploads/SignIn/Mail.png'/></i>
<input type="text" placeholder="почта" id="email" name="email" >
      </div>
      <div class="row">
        <i class="fas fa-lock"><img src='uploads/SignIn/Pass.png'/>	</i>
        <input type="password" placeholder="Пароль" id="password" name = "password">
      </div>

      <div class="row button">
        <input class="knopka" type = "submit" name = "" value="Отправить">
      </div>
      <div class="row button">
        <a href="signup.php"><input class="knopka" type="button" value="Авторизация"></a>
      </div>
	<br>
  <br>
	<center><a href="index.php" style='font-size: 18px; cursor: pointer;'>На главную</a></center>

    </form>


  </div>

  <?php
include('connect.php');

if (isset($_POST)) {
    if (empty($_POST['login'])) {
        echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Введите ваш логин</b>";
    } elseif (empty($_POST['email'])) {
        echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Введите ваш E-mail</b>";
    } elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $_POST['email'])) {
        echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Некорректный E-mail, например email@mail.ru</b>";
    } elseif (empty($_POST['password'])) {
        echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Придумайте пароль</b>";
    } elseif (!preg_match("/\A(\w){6,20}\Z/", $_POST['password'])) {
        echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Пароль должен быть от 6 до 20 символов</b>";
    } else {
        $login = htmlspecialchars($_POST['login']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $date = date("d-m-y в H:i");
        $password = md5($_POST['password']);
        $ip = $_SERVER['REMOTE_ADDR'];

        $query1 = mysqli_query($mysqli, "SELECT id FROM Users WHERE login='$login'");

        if (mysqli_num_rows($query1) > 0) {
            echo "<b style='position:absolute; bottom:265px; color:red; font-size:20px; text-align:center;'>Пользователь с таким логином уже зарегистрирован</b>";
        } else {
            $sql = "INSERT INTO `Users` (`id`, `login`, `email`, `password`, `data`, `ip`) VALUES (NULL, '$login', '$email', '$password', '$date', '$ip')";

            if ($mysqli->query($sql) === true) {
                echo "<meta http-equiv='refresh' content='0; URL=signup.php'>";
                exit("<b style='position:absolute; bottom:265px; color:green; font-size:20px; text-align:center;'>Вы успешно зарегистрировались!</b>");
            }
        }
        $mysqli->close();
    }
}
?>


</body>
</html>