<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заказы</title>

     <!--добавляем шрифт Montserrat с помощью google fonts-->
    
     <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="cabinet.css">
    
</head>
<body bgcolor="seashell">

<header>
    <div>Мои заказы</div>  
</header>            
<p><a href="cabinet.php" style="font-size:24px">Назад</a></p>
<form action="" method="post">
<p style="font-size:24px">Отменить заказ № </p>
<input type="text" name="otm" id="name">
<br> 
<input class="knopka" type = "submit" name = "Отправить"  value="Отменить">   
</form>    
<?php
include "connect.php";
$user_id=$_SESSION['id']; // присваивает переменной $user_id значение из массива $_SESSION с ключом 'id'

$o = mysqli_query($mysqli, "SELECT * FROM `Orderss` WHERE user_id='$user_id'");// запрос к базе данных с помощью функции mysqli_query.
                                                // В нем выбираются все строки из таблицы "Orderss", где значение поля "user_id" равно значению переменной $user_id.
                                                // query для выполнения запросов к бд
while ($row = mysqli_fetch_array($o)) { //  у каждой строки извлекаются значения полей "id", "desс" и "data" с помощью функции mysqli_fetch_array
   // mysqli_fetch_array - это функция, которая извлекает одну строку данных из результирующего набора и возвращает ее в виде массива. 
   // Этот массив содержит значения полей выбранной строки.
    $id = $row['id'];
    $d = $row['desс'];
    $date = $row['data'];
    echo '
    <body bgcolor = "">
    <hr>
    <p style="font-size:24px">Заказ №: '.$id.'</p>
    <p style="font-size:24px">Описание: '.$d.'</p>
    <p style="font-size:24px">Дата заказа: '.$date.'</p>
    <hr>
    ';
  }
?>
<?
$otm = htmlspecialchars($_POST['otm']);


                $query1 = mysqli_query($mysqli,"SELECT id FROM orderss WHERE id='$otm'"); //выбирает идентификаторы заказов из таблицы "orderss", 
                //где значение поля "id" соответствует значению переменной $otm. 
                //Результат запроса сохраняется в переменную $query1.

             if(mysqli_num_rows($query1)>0){
                $sql = "DELETE FROM `orderss` WHERE id='$otm'";

        if ($mysqli -> query($sql) === true){//=== сравнивает и значение, и тип данных. Если значение и тип совпадают, то результатом сравнения будет true
            echo"<meta http-equiv='refresh' content='0 URL=Orders.php'>";//выводит на экран HTML-код с тегом <meta>, который используется для обновления страницы. 
            //В атрибуте http-equiv указывается, какой HTTP-заголовок будет использован. 
            //В данном случае, заголовок "refresh" обновляет страницу. Атрибут content определяет время задержки обновления и URL, на который нужно перенаправить страницу.
            exit("<b><center><font size=6 color=green>Заказ отменён</font></center></b>");
        }
        }
                            

?>   

</body>
</html>