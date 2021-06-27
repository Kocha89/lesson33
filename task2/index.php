<?php
session_start();
include 'configs/dbconfig.php';

$link=mysqli_connect($host, $db_user, $db_password, $database);
$query="SELECT * from posts";
$result = mysqli_query($link,$query);

    if($result){
        while ($row = $result->fetch_assoc()) {
            $posts[]=$row;
        }

        $result->close();
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="style/style.css">
</head>
<body>
   <header class="header">
       <div class="container">           
            <nav class="menu">
            <ul class="menu__list">
                <li class="menu__list-item">
                    <a href="index.php" class="menu__link">Главная</a>
                </li>
                <li class="menu__list-item">
                    <a href="../news/index.php" class="menu__link">Новости</a>
                </li>
                <li class="menu__list-item">
                    <a href="login.php" class="menu__link">Профиль</a>
                </li>
                <li class="menu__list-item">
                    <a href="register.php" class="menu__link">Регистрация</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
				<li class="menu__list-item">
                    <a href="logout.php" class="menu__link">Выйти</a>
                </li>
				<?php endif;?>
            </ul>
        </nav>
       </div>
   </header>
   <section class="news">
				<?php
					foreach ($posts as $post) {
				?> 
					<div>
						<div><a href="../news/item.php?id=<?php echo $post['id'];?>"><?php echo $post['title']; ?></a></div>
						<hr>
					</div>
				<?php
					}				
				?>
			</div>

    </section>
    <footer id="colophon" class="site-footer" role="contentinfo">
    <nav class="menu">
            <ul class="menu__list">
                 <li class="menu__list-item">
                    <a href="index.php" class="menu__link2">Главная</a>
                </li>
                <li class="menu__list-item">
                    <a href="../news/index.php" class="menu__link2">Новости</a>
                </li>
                <li class="menu__list-item">
                    <a href="login.php" class="menu__link2">Профиль</a>
                </li>
                <li class="menu__list-item">
                    <a href="register.php" class="menu__link2">Регистрация</a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
				<li class="menu__list-item">
                    <a href="logout.php" class="menu__link">Выйти</a>
                </li>
				<?php endif;?>
            </ul>
        </nav>


<div class="site-info footer">
<div class="container">
    <div class="logo logo__footer">
        <div class="logo footer__inner">
                        
                    <a class="" href=""><div class="footer__description">Центр анализа политики здравоохранения</div></a>
                    
        </div>
        <div class="menu__footer">
            <div class="menu__footer-title">Мы в соцсетях</div>
                        <div class="vcard_socials__inner">
                        <ul class="vcard_socials">
                            <li class="vcard_socials_item icon_twi"><a href="#" target="_blank"></a></li>
                            <li class="vcard_socials_item icon_fb"><a href="#" target="_blank"></a></li>
                            <li class="vcard_socials_item icon_vk"><a href="#" target="_blank"></a></li>
                            <li class="vcard_socials_item icon_ok"><a href="#" target="_blank"></a></li>
                            <li class="vcard_socials_item icon_instagram"><a href="#" target="_blank"></a></li>
                        </ul>


                    </div>
                                
            </div>
 

</div>
    <div class="copy">Copyright © 2020 hpac.kg все права защищены</div>
</footer>

</div>
</div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/libs.min.js"></script>
  <script src="js/main.js"></script>
</body>
</html>