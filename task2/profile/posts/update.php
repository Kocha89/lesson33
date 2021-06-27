<?php
	session_start();
	include '../../configs/dbconfig.php';
	
	$errors=[];
	
	$isChanged=false;

	if (isset($_GET['id'])){
			$id = $_GET['id'];
			$link=mysqli_connect($host, $db_user, $db_password, $database);
			$query="SELECT * FROM posts WHERE id='$id'";

			$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
		
			if($result && mysqli_num_rows($result)>0){
				$post=$result->fetch_assoc();
				mysqli_free_result($result);
			}
		} else {
			echo "Нет такого товара";
			die;
		}
		mysqli_close($link);
	


	if (isset($_POST['submit'])) {
		if (empty($_POST['title'])) {
        	$errors['title'] =  'Заполните тему записи';
    	}

		if (isset($_POST['submit']) AND count($errors)==0) {
			$user_id=$_SESSION['user']['id'];
			$isChanged=true;
			if(mysqli_connect_errno() ) {
				printf('Не удалось подключиться: %$\n', mysql_connect_error());
				exit();
			}
			$link=mysqli_connect($host, $db_user, $db_password, $database);	

			$title = $link->real_escape_string(trim($_POST['title']));
			$text = $link->real_escape_string(trim($_POST['text']));
			$query="UPDATE posts SET title='$title', text='$text' WHERE id = '$id' AND user_id='$user_id'";
			$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));
			
			if($result == false)
			{
				printf("Ошибка: %s\n", mysqli_sqlstate($link));
			} 

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
			<a href="index.php">Назад</a>
			<h1>Изменение записи</h1>
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
				if ($isChanged) {
					echo "Запись изменена";
				} ?>
			</p>
			<form method="POST">
				<input class="form__input post__title" type="text" name="title" value="<?php echo $post['title'];?>" placeholder="Название продукта">
				<textarea class="form__input textarea" name="text" placeholder=""><?php echo $post['text'];?></textarea>
				<input class="form__input" type="submit" name='submit' value="Сохранить">
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