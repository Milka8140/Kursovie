<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
	<link rel="stylesheet" href="signupp.css">    
<div class="wrapper">
    <div class="title"><span>Авторизация</span></div>
    <form action="" method="post">
      <div class="row">
        <i class="fas fa-user"><img src='uploads/SignIn/Login.png'/></i>
        <input type="text" name="login_2" placeholder="Логин" id="login_2" >
      </div>
      <div class="row">
        <i class="fas fa-lock"><img src='uploads/SignIn/Pass.png'/>	</i>
        <input type="password" placeholder="Пароль" id="password_2" name = "password_2">
      </div>

      <div class="row button">
        <input class="knopka" type = "submit" name = "" value="Войти">
      </div>

      <div class="signup-link">Не зарегистрированы? <a href="reg.php">Зарегистрироваться</a></div>
	<br>
	<center><a href="index.php" style='font-size: 18px;'>На главную</a></center>

    </form>


  </div>
<br>
<br>

<?php
include('connect.php');

if (isset($_POST)) { // Проверка наличия данных в массиве $_POST
    if (empty($_POST['login_2'])) { // Проверка на пустоту значения 'login_2', полученного из массива $_POST
        $login_2 = $_POST['login_2']; // Присваивает переменной $login_2 значение 'login_2' из массива $_POST
        if ($login_2 == '') {
            unset($login_2);
            exit("<b style='position:absolute; bottom:295px; font-size:20px; color:red; text-align:center;'>Введите логин</b>");
        }
    } elseif (empty($_POST['password_2'])) {
        $password_2 = $_POST['password_2']; 
        if ($password_2 == '') {
            unset($password_2);
            exit("<b style='position:absolute; bottom:295px; font-size:20px; color:red; text-align:center;'>Введите пароль</b>");
        }
    }
?>

<?php
    
    $login_2 = stripslashes($login_2);
    $login_2 = htmlspecialchars($login_2);
    $password_2 = stripslashes($password_2);
    $password_2 = htmlspecialchars($password_2);
    $password_2 = trim($password_2);
    
    $login = $_POST['login_2'];
    $password = $_POST['password_2'];
    $password = md5($password);
    
    $user = mysqli_query($mysqli, "SELECT id FROM Users WHERE login='$login' AND password='$password'");
    $id_user = mysqli_fetch_array($user);
    
    if (empty($id_user['id'])) {
        // Если пользователь не найден, проверяем данные администратора
        $admin = mysqli_query($mysqli, "SELECT id FROM Admin WHERE login='$login' AND password='$password'");
        $id_admin = mysqli_fetch_array($admin);
    
        if (empty($id_admin['id'])) {
            exit("<b style='position: absolute; bottom:295px; font-size:20px; color:red; text-align:center;'>Логин или пароль не верный</b>");
        } else {
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            $_SESSION['id'] = $id_admin['id'];
            echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
        }
        
    } else {
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $password;
        $_SESSION['id'] = $id_user['id'];
        echo "<meta http-equiv='refresh' content='0; URL=index.php'>";
    }
    
    if (setcookie('login', $_POST['password'], strtotime("+30 days"), '/')) {
        setcookie('login', $_POST['login'], time() + 99999999);
        setcookie('password', $_POST['password'], time() + 99999999);
    }
}
?>

</body>
</html>