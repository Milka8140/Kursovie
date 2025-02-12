<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>

     <!--добавляем шрифт Montserrat с помощью google fonts-->
    
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="cabinet.css">
    
</head>
<body bgcolor="seashell">

<header>
    <div> Личный кабинет </div>  
</header>
<p><a href="index.php" style="font-size:24px">Главная</a></p>
                        <?
                        echo "<p >".$_SESSION['login']."</p>";
                    ?>
<p><a href="Orders.php" style="font-size:24px">Мои заказы</a></p>

<form action="" method="post">
<p style="font-size:24px">Введите имя</p>
<input type="text" name="name" id="name">
<br> 
<p style="font-size:24px">Введите номер телефона</p>
<input type="text" name="phone" id="phone" placeholder="+375XXXXXXXXX" >
<br>
<p style="font-size:24px">Описание заказа<br><textarea style="font-size: 28px;"name="desc" id="desc" cols="50" rows="10" placeholder="описание заказа"></textarea></p>
<br>
<input class="knopka" type = "submit" name = "Отправить"  >   
</form>

<?
include('connect.php');
if(isset($_POST)){//Проверка наличия данных в массиве $_POST
    if(empty($_POST['name'])){
        echo"<b><font size=6 color=red>Введите ваше ФИО</font></b>";  
    }elseif(empty($_POST['phone'])){
        echo"<b><font size=6 color=red>Введите ваш телефон</font></b>";
        
    }elseif(!preg_match("/^\+375{1}\d{9}$/",$_POST['phone'])){//Проверка соответствия значения 'phone', 
        //полученного из массива $_POST, заданному регулярному выражению. Если значение не соответствует регулярному выражению +375XXXXXXXXX
      echo"<b><center><font size=6 color=red>некорректный номер телефона</font></center></b>";
  }elseif(empty($_POST['desc'])){
      echo"<b><font size=6 color=red>Опишите заказ</font></b>";    
    }else{
        
        $user_id=$_SESSION['id']; //Присваивание переменной $user_id значения из массива $_SESSION с ключом 'id'. 
        $name=htmlspecialchars($_POST['name']);
        $phone=htmlspecialchars($_POST['phone']);
        $description=htmlspecialchars($_POST['desc']);
        $date=date("d-m-y в H:i");

//чтобы предотвратить возможные уязвимости и сохранить корректность данных.
        

        $sqll = "INSERT INTO `orderss` (`id`, `user_id`, `user_name`, `phon`, `desс`, `data`) VALUES (NULL, '$user_id', '$name', '$phone', '$description', '$date')";
echo"<p><font size=6 color=green>Успешно</font></p>";

        if ($mysqli -> query($sqll) === true){
            echo"<meta http-equiv='refresh' content='0 URL=Orders.php'>";
            exit("<b><center><font size=6 color=green>Заказ выполнен!</font></center></b>");

        }
        $mysqli -> close();

    }
}                     
?>
</body>
</html>