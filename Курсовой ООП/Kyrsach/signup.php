<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>

 <!--добавляем шрифт Montserrat с помощью google fonts-->
    
 <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="signup.css">
    
</head>
<body bgcolor="seashell">
    
<header>
    <div> Авторизация </div>  
</header>

<center>
    <form action="" method="post">
    <p style="font-size:24px">Введите логин</p>
    <input type="text" name="login_2" placeholder="логин" id="login_2" >
    <br> 
    <p style="font-size:24px">Введите пароль</p>
    <input type="password" placeholder="пароль" id="password_2" name = "password_2">
    <br>
    <input class="knopka" type = "submit" name = "" value="Вход"><br>
    <a href="reg.php" ><p style="font-size:24px">Зарегистрироваться</p></a> 
    </form>
</center>
<?
include('connect.php');
if(isset($_POST)){//Проверка наличия данных в массиве $_POST
  if(empty($_POST['login_2'])){//Проверка на пустоту значения 'login_2', полученного из массива $_POST. 
    $login_2 = $_POST['login_2']; //Присваивает переменной $login_2 значение 'login_2' из массива $_POST.
    if($login_2 == '') {
        unset($login_2);
exit("<b><center><font size=6 color=red>Введите логин</font></center></b>");
    } 
}
 elseif(empty($_POST['password_2'])){
    $password_2 = $_POST['password_2']; 
    if($password_2 == '') {
        unset($password_2);
exit("<b><center><font size=6 color=red>Введите пароль</font></center></b>");
    } 
 }
    $login_2=stripslashes($login_2);//Удаляет экранирование (\) символов из значения переменной $login_2.
    $login_2=htmlspecialchars($login_2);//Преобразует специальные HTML символы в их эквивалентные HTML-сущности в значении переменной $login_2.
     $password_2=stripslashes($password_2);//
    $password_2=htmlspecialchars($password_2);
    $password_2=trim($password_2);//Удаляет пробелы в начале и конце значения переменной $password_2.
    $login=$_POST['login_2'];//Присваивает переменной $login значение 'login_2' из массива $_POST.
     $password=$_POST['password_2'];
     $password=md5($password);//Хеширует значение переменной $password с помощью алгоритма MD5.

     
     $user=mysqli_query($mysqli, "SELECT id FROM Users WHERE login='$login' AND password = '$password'");
     //выборки идентификатора пользователя из таблицы 'Users', где значения полей 'login' и 'password' равны $login и $password соответственно. 
     //Результат запроса сохраняется в переменной $user.
     $id_user=mysqli_fetch_array($user);//Извлекает значение результата запроса $user в виде массива и сохраняет его в переменной $id_user.
     if(empty($id_user['id'])){
         exit("<b><center><font size=6 color=red>Введенный вами логин или пароль не верный</font></center></b>");
     }
     else{
         $_SESSION['login']=$login;// Сохраняет значение $login в сессионной переменной с ключом 'login'.
          $_SESSION['password']=$password;
           $_SESSION['id']=$id_user['id'];
            echo"<meta http-equiv='refresh' content='0 URL=index.php'>"; 
     }
     if(setcookie('login', $_POST['password'],strtotime("+30 days"),'/')){//Устанавливает cookie 'login' с значением $_POST['password'] и дополнительными параметрами.
        setcookie('login', $_POST['login'], time()+99999999);
        setcookie('password', $_POST['password'], time()+99999999);
        
    }
    
}

?>
</body>
</html>
<!--
    Cookie - это небольшие текстовые файлы, которые отправляются сервером сайта и сохраняются на компьютере пользователя. 
    Они используются для хранения информации о состоянии и настройках сайта, а также для отслеживания активности пользователя.

Cookie могут содержать различные данные, такие как идентификатор сессии, предпочтения пользователя, информацию о покупках и т. д. 
Когда пользователь посещает сайт, браузер отправляет cookie на сервер для связи с предыдущими запросами 
и для предоставления доступа к персонализированному контенту или функциям.
