<?php
session_start();
include 'configs/dbconfig.php';

$errors=[];

// SIGN UP USER
if (isset($_SESSION['user'])) {
	header('Location: profile/profile.php');
}
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
		$password = md5($password);		

		$sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
		$result = mysqli_query($link, $sql) or die(mysqli_error($link));
		$_SESSION['result']=$result;

		if (mysqli_num_rows($result) > 0) {
			$row=$result->fetch_assoc();
			if (isset($_POST['submit'])) {
				$_SESSION['user']['email']=$row['email'];
				$_SESSION['user']['first_name']=$row['first_name'];
				$_SESSION['user']['id']=$row['id'];
				$_SESSION['user']['last_name']=$row['last_name'];
				$_SESSION['user']['city']=$row['city'];
				$_SESSION['user']['user_id']=$row['user_id'];
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
             </ul>
        </nav>
       </div>
   </header>
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
			<div class="btn">
					<a class="btn__link" href="register.php">Регистрация</a>
			</div>
		</div>
	</div>

</body>
</html>