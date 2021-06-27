<?php
session_start();
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
        $email = $link->real_escape_string(trim($_POST['email']));
        $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) > 0) {
                  $errors['email'] ="Вы уже зарегистрированы.";
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
                    <a href="../task2/index.php" class="menu__link">Главная</a>
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
            <div>У вас уже есть аккаунт?<a href="login.php">Войти</a></div>
            <?php
             if (isset($_POST['submit']) && count($errors)===0) {
                $link=mysqli_connect($host, $db_user, $db_password, $database);
                $first_name = $link->real_escape_string(trim($_POST['first_name']));
                $last_name = $link->real_escape_string(trim($_POST['last_name']));  
                $password = $link->real_escape_string(trim($_POST['password'])); //encrypt password
                $password = md5($password);
                $city = $link->real_escape_string(trim($_POST['city']));

                if(mysqli_connect_errno() ) {
                    printf('Не удалось подключиться: %$\n', mysql_connect_error());
                }
        
   

                $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
                $query="INSERT INTO users (first_name, last_name, email, password, city) values('$first_name', '$last_name', '$email', '$password', '$city')";
        
                $result = mysqli_query($link,$query);
        
                if($result == false)
                {
                    printf('Ошибка: %$\n', mysqli_sqlstate($link));
                } else {
                    $link_address='login.php';
                    echo "<span style='color:green;text-align:center;'>Вы зарегистрировались. Вы можете теперь войти.</span>";
                    echo "<a href='$link_address'>Войти</a>";
                }
                
                // LOGIN
                mysqli_close($link);
            }
            ?>
		</div>
	</div>

</body>
</html>