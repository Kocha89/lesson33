<?php
	session_start();
	include '../configs/dbconfig.php';

	$isChanged=false;
	
	if (isset($_POST['submit'])) {
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$isChanged=true;
		$city=$_POST['city'];
		$id=$_SESSION['id'];
		
		$link=mysqli_connect($host, $db_user, $db_password, $database);

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
	<title>News</title>
	<link rel="stylesheet" href="../style/style.css">
</head>
<body>
	<div class="products__inner">
		<div class="container">
			<?php if (isset($_SESSION['email']) && isset($_SESSION['password'])): ?>
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
				<input class="form__input" type="text" name="first_name" value="<?php echo $_SESSION['first_name'];?>" placeholder="Имя">
				<input class="form__input" type="text" value="<?php echo $_SESSION['last_name'];?>" name="last_name" placeholder="Фамилия">
				<input class="form__input" type="text" value="<?php echo $_SESSION['city'];?>" name="city" placeholder="Город">
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