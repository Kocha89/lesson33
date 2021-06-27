<?php
    session_start();
    include '../task2/configs/dbconfig.php';

    $link=mysqli_connect($host, $db_user, $db_password, $database);

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        echo "Нет такого товара";
        die;
    }

    $query="SELECT * FROM posts WHERE id='$id'";

    $result = mysqli_query($link,$query);

    if($result && mysqli_num_rows($result)>0){
        $post=$result->fetch_assoc();
        mysqli_free_result($result);
    }

    mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="../task2/style/style.css">
</head>
<body>
   <header class="header">
       <div class="container">           
            <nav class="menu">
            <ul class="menu__list">
                <li class="menu__list-item">
                    <a href="../task2/index.php" class="menu__link">Главная</a>
                </li>
                <li class="menu__list-item">
                    <a href="index.php" class="menu__link">Новости</a>
                </li>
                <li class="menu__list-item">
                    <a href="../task2/login.php" class="menu__link">Профиль</a>
                </li>
                <li class="menu__list-item">
                    <a href="../task2/register.php" class="menu__link">Регистрация</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
				<li class="menu__list-item">
                    <a href="../task2/logout.php" class="menu__link">Выйти</a>
                </li>
				<?php endif;?>
            </ul>
        </nav>
       </div>
   </header>
<body>
    <div class="products__inner">
        <div class="container">
            <div class="btn">
                <a class="btn__link" href="index.php">Назад</a>
            </div> 
            <h1><?php echo $post['title']; ?></h1>       
            <div class="news">
                    <div>
                        <div>Название статьи:<?php echo $post['title']; ?></div>
                        <div>Текст:<?php echo $post['text']; ?></div>
                    </div>
            </div>

        </div>
    </div>

</body>
</html>