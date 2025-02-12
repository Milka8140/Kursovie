<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>CarDeal</h1>
    </header>
    <main>
        <nav class="menu">
            <ul>
                <li><a href="car.php">Автомобили</a></li>
                <li><a href="detail.php">Запчасти</a></li>
		        <li><a href="comments.php">Отзывы</a></li>

                <?
                    
                    if(!$_SESSION['login'] AND !$_SESSION['password']){ // проверка наличия значений в переменных $_SESSION['email'] и $_SESSION['password']
                                                                        // $_SESSION - это массив, который хранит данные, связанные с текущей сессией пользователя
                        echo '<li><a href="signup.php">Войти</a></li>';
                    }else{
                        echo "<li><img src='uploads/UserIco.png' style='width:50px;height:50px;'>".$_SESSION['login']."</li>";
                        echo '<li><a href="cabinet.php">Кабинет</a></li>';
                        echo '<li><a href="exit.php">Выйти</a></li>';
                    }
                    ?>

            </ul>
        </nav>

        <div class="content">
            <p><b>CarDeal</b> – ваш надёжный партнёр в мире автомобилей. Мы предлагаем широкий выбор новых и подержанных автомобилей, качественные запчасти и профессиональное обслуживание. 
                <br> <br>
                Откройте для себя: <br>
                - Лучшие предложения на автомобили. <br>
                - Качественные запчасти и аксессуары. <br>
                - Высокий уровень сервиса. <br>
                <br> 
                Почему выбирают нас: <br>
                - Опыт и профессионализм. <br>
                - Индивидуальный подход. <br>
                - Гарантия качества. <br> <br>
                Присоединяйтесь к <b>CarDeal</b> и найдите автомобиль своей мечты уже сегодня! Мы уверены, что вы останетесь довольны нашим сервисом и качеством наших автомобилей.
            </p>
        </div>

        <aside class="photo">
            <img src="\main.foto.jpg" alt="Фото 1">
        </aside>
    </main>
    
    <footer>
        <p class="contact-inf">Контактная информация</p>
       <div class="phone">
        <p>Номер телефона: <br>
            +375 (29) 12 34 567 <br>
            +375 (44) 98 76 543</p>

            <div class="email">
                <p>Электронная почта: <br>
                    car_deal@mail.ru</p>
            </div>

            <div class="adress">
                <p>Адрес: <br>
                    Минск ул. Широкая 17</p>
            </div>
            
    </div> 
    </footer>
</body>
</html>