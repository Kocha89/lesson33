<?php
	session_start();
	include '../../configs/dbconfig.php';

	$title = isset($_POST['title']) ? $_POST['title'] : '';
	$text = isset($_POST['text']) ? $_POST['text'] : '';	
	$user_id = $_SESSION['user_id'];
	$errors=[];

	$link=mysqli_connect($host, $user, $password, $database);
	$isChanged=false;

	if (isset($_GET['id'])){
		$id = $_GET['id'];
	} else {
		echo "Нет такого товара";
		die;
	}
	

	$query="SELECT * FROM posts WHERE id='$id'";

	$result=mysqli_query($link, $query) or die("Ошибка" . mysqli_error($link));

	if($result && mysqli_num_rows($result)>0){
		$post=$result->fetch_assoc();
		mysqli_free_result($result);
	}

	if (isset($_POST['submit'])) {
		if (empty($_POST['title'])) {
        	$errors['title'] =  'Заполните тему записи';
    	}

    	$title = $link->real_escape_string(trim($_POST['title']));
    	$text = $link->real_escape_string(trim($_POST['text']));


		if (isset($_POST['submit']) && count($errors)===0) {
			$isChanged=true;
			if(mysqli_connect_errno() ) {
			printf('Не удалось подключиться: %$\n', mysql_connect_error());
			exit();
			}

			$query="UPDATE posts SET title='$title', text='$text' WHERE id = '$id' AND user_id='$user_id'";
			
			$result = mysqli_query($link,$query);

			if($result == false)
			{
				printf("Ошибка: %s\n", mysqli_sqlstate($link));
			} 
		}
	}
		
	mysqli_close($link);
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
			<?php if (isset($_SESSION['user_id'])): ?>
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
                    session_start();
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    session_destroy();
                    header("location:../../login.php"); ?>
            <?php endif;?>
		</div>
	</div>

</body>
</html>