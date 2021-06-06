<?php
session_start();
include 'configs/dbconfig.php';

$errors=[];

// SIGN UP USER

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите email';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите ваш пароль';
    }
	if (count($errors) == 0) {

		$link=mysqli_connect($host, $db_user, $db_password, $database);

		$email = $link->real_escape_string(trim($_POST['email']));
		$password = $link->real_escape_string(trim($_POST['password']));		

		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
		$result = mysqli_query($link, $sql) or die(mysqli_error($link));
		$_SESSION['result']=$result;

		if (mysqli_num_rows($result) > 0) {
			$row=$result->fetch_assoc();
			if (isset($_POST['submit'])) {
				$_SESSION['email']=$row['email'];
				$_SESSION['password']=$row['password'];
				$_SESSION['first_name']=$row['first_name'];
				$_SESSION['id']=$row['id'];
				$_SESSION['last_name']=$row['last_name'];
				$_SESSION['city']=$row['city'];
				header('Location: profile/profile.php');
			}  				  
   
	   } else {
		   //  $message = "Invalid username or password!";
		   
		   $errors['password'] = "Почта или логин не правильные"; 
	   }
			// LOGIN
		mysqli_close($link);
	}
}





 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>News</title>
	<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div class="form__inner">
		<div class="container">
			<h1>Логин</h1>
			<?php if (count($errors) > 0): ?>
			  <div class="alert alert-danger">
			    <?php foreach ($errors as $error): ?>
			    <li>
			      <?php echo $error; ?>
			    </li>
			    <?php endforeach;?>
			  </div>
			<?php endif;?>
			<form method="post">
				<input class="input__form" type="text" name="email" placeholder="Email">
				<input class="input__form" type="text" name="password" placeholder="Пароль">
				<input class="input__form" type="submit" name="submit" value="Войти">
			</form>
			<div class="register">
					<a class="register__text" href="register.php">Регистрация</a>
			</div>
		</div>
	</div>

</body>
</html>