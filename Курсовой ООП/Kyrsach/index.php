<? session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>

    <!--добавляем шрифт Montserrat с помощью google fonts-->

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="main.css">
     <!--
    display: flex             для того чтобы использовать 2 свойства ниже для выравнивания
    justify-content: center   для выравнивания по центру по горизонтали
    align-items: center       для выравнивания по центру по вертикали
    box-sizing: border-box    ширина и высота элемента указываются включая границы и отступы
    line-height               устанавливает высоту строки
    list-style-type           маркировака списка

    commect может быть моделью
    HTML CSS View 
    php код это контроллер

     -->

</head>

<body bgcolor="seashell">

    <header style="">
      <div> MyAtelier </div>  
    </header>

    <div class="mainmenu">
        <div class="menuback">
            <div class="menu">Меню</div>
            <div>
                <ul>
                    <li><a href="index.php">Главная</a></li>
                    <li><a href="o-nas.php">О нас</a></li>
                    <li><a href="portfolio.php">Портфолио</a></li>
                    <li><a href="service-price.php">Цены и услуги</a></li>
                    <li><a href="comments.php">Комментарии</a></li>
                    
                    <?
                    
                    if(!$_SESSION['email'] AND !$_SESSION['password']){ // проверка наличия значений в переменных $_SESSION['email'] и $_SESSION['password']
                                                                        // $_SESSION - это массив, который хранит данные, связанные с текущей сессией пользователя
                        echo '<li><a href="signup.php">Войти</a></li>';
                    }else{
                        echo '<li><a href="cabinet.php">Личный кабинет</a></li>';
                        echo $_SESSION['login'];
                        echo '<li><a href="exit.php">Выйти</a></li>';
                    }
                    ?>
                    
                </ul>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="insidecontent">
        Добро пожаловать в наше ателье по пошиву пижам!
        <br>  <br> 
        Уникальные пижамы, созданные с любовью и качественно исполненные - вот то, чем мы гордимся. 
        В нашем ателье мы делаем все возможное, чтобы сделать ваши ночи комфортными и стильными.
        <br>  <br>
        Наша команда профессиональных портных обладает богатым опытом в создании пижам, которые сочетают в себе комфорт и модный дизайн. 
        Мы работаем с самыми качественными материалами, чтобы каждая пижама была мягкой, приятной на ощупь и прочной.
        У нас вы можете заказать пижаму на заказ, полностью соответствующую вашим предпочтениям и индивидуальным параметрам. 
        Мы уделяем внимание каждой детали - от выбора ткани и фурнитуры до вышивки и украшений. 
        <br>  <br>
        Мы гарантируем высокое качество нашей продукции и индивидуальный подход к каждому клиенту. 
        Мы стремимся создать пижамы, в которых вы будете чувствовать себя комфортно и уверенно.
        Загляните в нашу галерею, чтобы посмотреть наши работы, и свяжитесь с нами, чтобы сделать заказ или задать любые вопросы. 
        Мы с нетерпением ждем возможности создать для вас идеальную пижаму!
        <br> <br>
        Добро пожаловать в мир комфорта и стиля с нашим ателье по пошиву пижам!
    </div>
</div>
    
    <div class="photo">
        <img src="img\photo_2023-11-05_00-39-24.jpg" alt="просто красивая картинка">
    </div>
    
    <footer>
        <div class="contacts" >Контакты</div>
    </footer>
    <div class="phone">
        +375 (29) 814-02-51
       </div>
    <div class="email">valmusulana@gmail.com</div>
    <div class="adress">г. Минск  пр-т Независимости, 40</div>

</body>
</html>