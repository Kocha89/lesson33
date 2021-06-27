<?php
	session_start();
	include '../configs/dbconfig.php';

	$isChanged=false;
	
	if (isset($_POST['submit'])) {
		$link=mysqli_connect($host, $db_user, $db_password, $database);

		$first_name=$link->real_escape_string(trim($_POST['first_name']));
		$last_name=$link->real_escape_string(trim($_POST['last_name']));
		$isChanged=true;
		$city=$link->real_escape_string(trim($_POST['city']));
		$id=$_SESSION['user']['id'];		

		$query="UPDATE users SET first_name = '$first_name', last_name = '$last_name', city = '$city' WHERE id = '$id'";
		$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
		mysqli_close($link);
	}
	if(mysqli_connect_errno() ) {
	printf('Не удалось подключиться: %$\n', mysql_connect_error());
	exit();
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
	<div class="products__inner">
		<div class="container">
			<?php if (isset($_SESSION['user'])): ?>
			<div class="btn">
                <a class="btn__link" href="profile.php">Назад</a>
            </div>
			<h1>Профиль пользователя</h1>
			<p class="profile__text">
				<?php 
				if ($isChanged) {
					echo "Профиль изменен";
				}
				?>
			</p>
			
			<form method="POST">
				<input class="form__input" type="text" name="first_name" value="<?php echo $_SESSION['user']['first_name'];?>" placeholder="Имя">
				<input class="form__input" type="text" value="<?php echo $_SESSION['user']['last_name'];?>" name="last_name" placeholder="Фамилия">
				<input class="form__input" type="text" value="<?php echo $_SESSION['user']['city'];?>" name="city" placeholder="Город">
				<input class="form__input" type="submit" name="submit" value="Сохранить">
			</form>
			<?php else:
                    session_start();
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    session_destroy();
                    header("location:login.php"); ?>
            <?php endif;?>
		</div>
	</div>

</body>
</html>