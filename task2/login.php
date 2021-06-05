<?php
session_start();
include 'configs/dbconfig.php';

$password = "";
$email = "";
$errors=[];


$link=mysqli_connect($host, $user, $password, $database);

// SIGN UP USER

if (isset($_POST['submit'])) {
    if (empty($_POST['email'])) {
        $errors['email'] = 'Введите email';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите ваш пароль';
    }

    $email = $link->real_escape_string(trim($_POST['email']));
    $password = $link->real_escape_string(trim($_POST['password']));

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $result = mysqli_query($link, $sql) or die(mysqli_error($link));;
    
    if (mysqli_num_rows($result) > 0) {
 		if (isset($_POST['submit'])) {
 			$_SESSION['email']=$_POST['email'];
 			$_SESSION['password']=$_POST['password'];
 			header('Location: profile/profile.php');
 		}  				  

    } else {
        //  $message = "Invalid username or password!";
        
        $errors['password'] = "Почта или логин не правильные"; 
    }

}


// LOGIN
 mysqli_close($link);

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
		</div>
	</div>

</body>
</html>