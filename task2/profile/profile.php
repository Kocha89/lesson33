<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header("location:../login.php");
       }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="../style/style.css">
</head>
<body>
   <header class="header">
       <div class="container">           
            <nav class="menu">
            <ul class="menu__list">
                <li class="menu__list-item">
                    <a href="../index.php" class="menu__link">Главная</a>
                </li>
                <li class="menu__list-item">
                    <a href="../../news/index.php" class="menu__link">Новости</a>
                </li>
                <li class="menu__list-item">
                    <a href="../login.php" class="menu__link">Профиль</a>
                </li>
                <li class="menu__list-item">
                    <a href="../register.php" class="menu__link">Регистрация</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
				<li class="menu__list-item">
                    <a href="../logout.php" class="menu__link">Выйти</a>
                </li>
				<?php endif;?>
            </ul>
        </nav>
       </div>
   </header>
<body>
    <div class="form">
        <div class="container">
             <div class="form__inner2">
            <div class="registration2">
            <h2>Личный кабинет</h2>
            <?php if($_SESSION['user']){
                echo "Привет, " . $_SESSION['user']['first_name'] . " .Добро пожаловать в личный кабинет."; 
                } else {
                //  $message = "Invalid username or password!";
                
                echo  "Invalid username or password!";

             } ?>
            <div>
                <p>Имя: <?php echo $_SESSION['user']['first_name'];?></p>
                <p>Фамилия: <?php echo $_SESSION['user']['last_name'];?></p>            
                <div class="btn">
                    <a class="btn__link" href="update.php?id=<?php echo $_SESSION['user']['id'];?>">Изменить</a>
                </div>
                
            </div>
            <div class="btn">
                <a class="btn__link" href="posts/index.php">Список новостей</a>
            </div>
            <div>
            </div>
            </div>
            </div>

        </div>
    </div>
</body>
</html>
