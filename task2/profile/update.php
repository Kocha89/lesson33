<?php
	session_start();
	include '../configs/dbconfig.php';


    $link=mysqli_connect($host, $db_user, $db_password, $database);


    $email=$_SESSION['email'];
    $password=$_SESSION['password'];

  

    $query="SELECT * FROM users WHERE email='$email' AND password='$password'";

	$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
	$isChanged=false;

	if($result && mysqli_num_rows($result)>0){
		$row=$result->fetch_assoc();
		$first_name=$row['first_name'];
		$last_name=$row['last_name'];
		$city=$row['city'];
		$id=$row['id'];
	}

	
	if (isset($_POST['submit'])) {
		if(isset($_POST['first_name'])) {
			$first_name=$link->real_escape_string(trim($_POST['first_name']));
			$isChanged=true;
		} 

		if(isset($_POST['last_name'])) {
			$last_name=$link->real_escape_string(trim($_POST['last_name']));
		} 
		if(isset($_POST['city'])) {
			$city=$link->real_escape_string(trim($_POST['city']));
		} 
		if(mysqli_connect_errno() ) {
		printf('Не удалось подключиться: %$\n', mysql_connect_error());
		exit();
		}

		$query="UPDATE users SET first_name = '$first_name', last_name = '$last_name', city = '$city' WHERE id = '$id'";
		
		
		$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));

		
	}

	mysqli_close($link);
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
				<input class="form__input" type="text" name="first_name" value="<?php echo $row['first_name'];?>" placeholder="Имя">
				<input class="form__input" type="text" value="<?php echo $row['last_name'];?>" name="last_name" placeholder="Фамилия">
				<input class="form__input" type="text" value="<?php echo $row['city'];?>" name="city" placeholder="Город">
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