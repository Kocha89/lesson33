<?php
	session_start();
	include '../../configs/dbconfig.php';
	$link=mysqli_connect($host, $db_user, $db_password, $database);
	$user_id=$_SESSION['user']['id'];
	$query="SELECT * from posts WHERE user_id='$user_id'";
	$result = mysqli_query($link,$query);

		if($result){
			while ($row = $result->fetch_assoc()) {
				$posts[]=$row;
			}

			$result->close();
		}
	if (isset($_SESSION['user'])) {
		$link=mysqli_connect($host, $db_user, $db_password, $database);
		$query="SELECT * from posts WHERE user_id='$user_id'";

		$result = mysqli_query($link,$query);

		if($result){
			while ($row = $result->fetch_assoc()) {
				$posts[]=$row;
			}

			$result->close();
		}

		
		if(mysqli_connect_errno() ) {
			printf('Не удалось подключиться: %$\n', mysql_connect_error());
		}

		mysqli_close($link);
		}
	
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
   <header class="header">
       <div class="container">           
            <nav class="menu">
            <ul class="menu__list">
				<li class="menu__list-item">
                    <a href="../../index.php" class="menu__link">Главная</a>
                </li>
                <li class="menu__list-item">
                    <a href="../../../news/index.php" class="menu__link">Новости</a>
                </li>
                <li class="menu__list-item">
                    <a href="../../login.php" class="menu__link">Профиль</a>
                </li>
                <li class="menu__list-item">
                    <a href="../../register.php" class="menu__link">Регистрация</a>
                </li>
				<?php if (isset($_SESSION['user'])): ?>
				<li class="menu__list-item">
                    <a href="../../logout.php" class="menu__link">Выйти</a>
                </li>
				<?php endif;?>
            </ul>
        </nav>
       </div>
   </header>
<body>
	<div class="products__inner">
		<div class="container">
			<?php if (isset($_SESSION['user'])): ?>
			<div class="profile">
				<div class="profile__link">
					<p>Имя: <?php echo $_SESSION['user']['first_name']; ?></p>
				</div>
			</div>
			<h1>Список новостей</h1>
			<div class="btn">
				<a class="btn__link" href="create.php">Создать запись</a>
			</div>			
			<div class="news">
			<?php if (isset($posts)): ?>
				<?php
					foreach ($posts as $post) {
				?> 
					<div>
						<div>Название статьи:<?php echo $post['title']; ?></div>
						<div>Текст:<?php echo $post['text']; ?></div>
						<div>
							<a href="update.php?id=<?php echo $post['id'];?>">Изменить</a>
						</div>
						<div>
							<a href="delete.php?id=<?php echo $post['id'];?>">Удалить</a>
						</div>
						<hr>
					</div>
				<?php
					}				
				?>
			</div>
			<?php else: ?>
			<p>Нет новостей</p>
			<?php endif;?>
			<?php else:
                    unset($_SESSION['user']);
                    session_destroy();
                    header("location:../../login.php"); ?>
            <?php endif;?>
		</div>
	</div>

</body>
</html>