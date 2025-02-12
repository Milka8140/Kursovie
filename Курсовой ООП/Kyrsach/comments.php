<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Комментарии</title>

 <!--добавляем шрифт Montserrat с помощью google fonts-->
 
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="comments.css">
    
</head>
<body bgcolor="seashell">
    
<header>
    <div> Комментарии </div>  
</header>
<p><a href="index.php" style="font-size:24px">Главная</a></p>
<form action="" method="post">
    <p style="font-size:24px">Введите комментарий<br>
<textarea style="font-size: 28px;"name="comment" cols="50" rows="8" placeholder="комментарий"></textarea></p>
<br>
<input class="knopka" type = "submit" name = "Отправить" >
</form>


<?php
include "connect.php";
$user_id=$_SESSION['id']; //Присваивание переменной $user_id значения из массива $_SESSION с ключом 'id'. 
$user_log=$_SESSION['login'];//Присваивание переменной $user_log значения из массива $_SESSION с ключом 'login'
$content = htmlspecialchars($_POST['comment']); //Присваивание переменной $content значения из массива $_POST с ключом 'comment'. 
//Функция htmlspecialchars используется для преобразования специальных HTML символов в их эквивалентные HTML-сущности, 
//чтобы предотвратить возможные уязвимости и сохранить корректность данных.
$date=date("d-m-y в H:i");//Присваивание переменной $date текущего значения даты и времени в формате "день-месяц-год в часы:минуты".


if(isset($_POST)){//Проверка наличия данных в массиве $_POST


if(!$_SESSION['login'] AND !$_SESSION['password']){
                        echo '<br><b><font size=6 color=red>Войдите, чтобы оставить комментарий.</font></b>';
                    }else{

if(empty($_POST['comment'])){
    echo '<br><p><font size=6 color=red>Введите комментарий</font></p>';
}else{
                            $sqll = "INSERT INTO `comments` (`id`, `author_login`, `content`, `data`) VALUES (NULL , '$user_log', '$content', '$date')";

        if ($mysqli -> query($sqll) === true){
            echo"<meta http-equiv='refresh' content='0 URL=comments.php'>";
            exit("<p><center><font size=6 color=green>Добавлен!</font></center></p>");
                        }
                        $mysqli -> close();
                    }
                    }
                }

?>                    
<?                    
$c = mysqli_query($mysqli, "SELECT * FROM `comments`");
while ($row = mysqli_fetch_array($c)) {// выполняется для каждой строки данных из результата запроса. 
    //Внутри цикла каждая строка данных извлекается с помощью функции mysqli_fetch_array и сохраняется в массиве $row.
    $dat = $row['data'];// выполняется для каждой строки данных из результата запроса. 
    //Внутри цикла каждая строка данных извлекается с помощью функции mysqli_fetch_array и сохраняется в массиве $row.
    $auth = $row['author_login'];
    $con = $row['content'];
    echo '
    <body bgcolor = "">
    <hr>
    <p style="font-size:24px" >Автор: '.$auth.'</p>
    <p style="font-size:24px" >Комментарий: '.$con.'</p>
    <p style="font-size:24px" >'.$dat.'</p>
    <hr>';
  }
?>
</body>
</html>