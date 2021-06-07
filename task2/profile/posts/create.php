<?php
	session_start();
	include '../../configs/dbconfig.php';

	$errors=[];
	
	$isAdded=false;

	if (isset($_POST['submit'])) {
		if (empty($_POST['title'])) {
        	$errors['title'] =  'Заполните тему записи';
    	}
		if (empty($_POST['text'])) {
        	$errors['text'] =  'Напишите текст';
    	}
    	

    	if (isset($_POST['submit']) && count($errors)===0) {
			$user_id = $_SESSION['id'];
			$isAdded=true;

			$link=mysqli_connect($host, $db_user, $db_password, $database);

			$title = $link->real_escape_string(trim($_POST['title']));
    		$text = $link->real_escape_string(trim($_POST['text']));

			$query="INSERT INTO posts (title, text, user_id, catid) values('$title', '$text', '$user_id', '2')";
			$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
			mysqli_close($link);

			if(mysqli_connect_errno() ) {
			printf('Не удалось подключиться: %$\n', mysql_connect_error());
			}
		
		}

	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>News</title>
	<link rel="stylesheet" href="../../style/style.css">
</head>
<body>
	<div class="products__inner">
		<div class="container">
			<?php if (isset($_SESSION['id'])): ?>
			<a href="index.php">Назад</a>
			<h1>Создать запись</h1>
			<?php if (count($errors) > 0): ?>
			  <div class="alert alert-danger">
			    <?php foreach ($errors as $error): ?>
			    <li>
			      <?php echo $error; ?>
			    </li>
			    <?php endforeach;?>
			  </div>
			<?php endif;?>
			<p class="profile__text">
				<?php 
				if ($isAdded) {
					echo "Запись добавлена";
				}
				?>
			</p>
			<form method="POST">
				<input class="form__input post__title" type="text" name="title" placeholder="Тема записи">
				<textarea class="form__input textarea" name="text"></textarea>  
				<input class="form__input" type="hidden" name="user_id">
				<input class="form__input" type="submit" name="submit" value="Добавить">
			</form>
			<?php else:
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    session_destroy();
                    header("location:../../login.php"); ?>
            <?php endif;?>
		</div>
	</div>

</body>
</html>