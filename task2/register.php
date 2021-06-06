<?php

include 'configs/dbconfig.php';

$errors=[];

// SIGN UP USER

if (isset($_POST['submit'])) {
    if (empty($_POST['first_name'])) {
        $errors['first_name'] =  'Заполните ваше имя';
    }
    if (empty($_POST['last_name'])) {
        $errors['last_name'] = 'Заполните вашу фамилию';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Заполните ваш email';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Введите пароль';
    }
    if (isset($_POST['password']) && $_POST['password'] !== $_POST['password_2']) {
        $errors['password_2'] = 'Два пароля не совпадают';
    }
    if (empty($_POST['city'])) {
        $errors['city'] = 'Заполните поле город';
    }

    if ($_POST['email']) {
        $link=mysqli_connect($host, $db_user, $db_password, $database);
        $first_name = $link->real_escape_string(trim($_POST['first_name']));
        $last_name = $link->real_escape_string(trim($_POST['last_name']));
        $email = $link->real_escape_string(trim($_POST['email']));
        $password = $link->real_escape_string(trim($_POST['password'])); //encrypt password
        $city = $link->real_escape_string(trim($_POST['city']));

        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0) {
                  $errors['email'] ="Вы уже зарегистрированы.Страница перенаправиться на главную страницу через 5 секунд.";
                  header( "refresh:5;url=login.php" );
        } 
                // LOGIN
        mysqli_close($link);
    }
    

    if (isset($_POST['submit']) && count($errors)===0) {
        if(mysqli_connect_errno() ) {
            printf('Не удалось подключиться: %$\n', mysql_connect_error());
        }

        $link=mysqli_connect($host, $db_user, $db_password, $database);
        $query="INSERT INTO users (first_name, last_name, email, password, city) values('$first_name', '$last_name', '$email', '$password', '$city')";

        $result = mysqli_query($link,$query);

        if($result == false)
        {
            printf('Ошибка: %$\n', mysqli_sqlstate($link));
        } else {
            echo "Вы зарегистрировались";
            header('refresh:2;url=login.php');
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
			<h1>Регистрация</h1>
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
				<input class="input__form" type="text" name="first_name" placeholder="Имя">
				<input class="input__form" type="text" name="last_name" placeholder="Фамилия">
				<input class="input__form" type="text" name="city" placeholder="Город">
				<input class="input__form" type="text" name="email" placeholder="Email">
				<input class="input__form" type="text" name="password" placeholder="Пароль">
				<input class="input__form" type="text" name="password_2" placeholder="Повторить пароль">
				<input class="input__form" type="submit" name="submit" value="Зарегистрироваться">
			</form>
		</div>
	</div>

</body>
</html>