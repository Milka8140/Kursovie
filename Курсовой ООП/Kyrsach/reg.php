<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

 <!--добавляем шрифт Montserrat с помощью google fonts-->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="reg.css">
    
</head>
<body bgcolor="seashell">
    
<header>
    <div> Регистрация </div>  
</header>
<center>
    <p><a href="signup.php" style="font-size:24px">Назад</a></p>
    <form action="" method="post">
    <p style="font-size:24px">Введите логин</p>
    <input type="text" placeholder="логин" id="login" name="login" >
    <br>
    <p style="font-size:24px">Введите почту</p>
    <input type="text" placeholder="почта" id="email" name="email" >
    <br>
    <p style="font-size:24px">Введите пароль</p>
    <input type="password" placeholder="пароль"  id="password" name="password">
    <br>
    <input class="knopka" type = "submit" name = "Отправить" >
    <br>
    <br>
    </form> 
</center>
<?
include('connect.php');
if(isset($_POST)){
    if(empty($_POST['login'])){
        echo"<b><center><font size=6 color=red>Введите ваш логин</font></center></b>";
    }
    elseif(empty($_POST['email'])){
        echo"<b><center><font size=6 color=red>Введите ваш E-mail</font></center></b>";
    
    } elseif(!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/",$_POST['email'])){
      echo"<b><center><font size=6 color=red>некоректный E-mail, например domain@domain.ru</font></center></b>";
        }
        elseif(empty($_POST['password'])){
        echo"<b><center><font size=6 color=red>Придумайте пароль</font></center></b>";
    }
    elseif(!preg_match("/\A(\w){6,20}\Z/", $_POST['password'])){
         echo"<b><center><font size=6 color=red>Пароль должен быnь от 6 до 20 символов</font></center></b>"; 
    }else
    {
        $login=htmlspecialchars($_POST['login']);
        $email=htmlspecialchars($_POST['email']);
        $password=htmlspecialchars($_POST['password']);
        $date=date("d-m-y в H:i");
        $password=(md5($_POST['password']));
        $ip=$_SERVER['REMOTE_ADDR'];

        $query1 = mysqli_query($mysqli,"SELECT id FROM Users WHERE login='$login'");

             if(mysqli_num_rows($query1)>0){
                echo"<b><center><font size=6 color=red>пользователь с таким логином уже зарегистрированн</font></center></b>";
             } else{

          $sql = "INSERT INTO `Users` (`id`, `login`, `email`, `password`, `data`, `ip`) VALUES (NULL,'$login','$email', '$password', '$date', '$ip')";

        if ($mysqli -> query($sql) === true){
            echo"<meta http-equiv='refresh' cont ent='0 URL=signup.php'>";
            exit("<b><center><font size=6 color=green>Вы успешно зарегистрировались!</font></center></b>");

        }
        $mysqli -> close();
        }

    }

}                        
?>
</body>
</html>