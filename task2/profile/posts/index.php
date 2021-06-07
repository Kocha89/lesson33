<?php
	session_start();
	include '../../configs/dbconfig.php';
  
	if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
		$user_id=$_SESSION['id'];
		$link=mysqli_connect($host, $db_user, $db_password, $database);
		$query="SELECT * from posts WHERE user_id='$user_id'";

		$result = mysqli_query($link,$query);

		if($result){
			while ($row = $result->fetch_assoc()) {
				$posts[]=$row;
			}

			$result->close();
		}

		
		if(mysqli_connect_errno() ) {
			printf('Не удалось подключиться: %$\n', mysql_connect_error());
		}

		mysqli_close($link);
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
			<?php if (isset($_SESSION['email']) && isset($_SESSION['password'])): ?>
			<div class="profile">
				<div class="profile__link">
					<div class="btn">
						<a class="btn__link" href="../profile.php">Профиль</a>
					</div>
					<p>Имя: <?php echo $_SESSION['first_name']; ?></p>
				</div>
			</div>
			<h1>Список новостей</h1>
			<div class="btn">
				<a class="btn__link" href="create.php">Создать запись</a>
			</div>			
			<div class="news">
			<?php if (isset($posts)): ?>
				<?php
					foreach ($posts as $post) {
				?> 
					<div>
						<div>Название статьи:<?php echo $post['title']; ?></div>
						<div>Текст:<?php echo $post['text']; ?></div>
						<div>
							<a href="update.php?id=<?php echo $post['id'];?>">Изменить</a>
						</div>
						<div>
							<a href="delete.php?id=<?php echo $post['id'];?>">Удалить</a>
						</div>
						<hr>
					</div>
				<?php
					}				
				?>
			</div>
			<?php else: ?>
			<p>Нет новостей</p>
			<?php endif;?>
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