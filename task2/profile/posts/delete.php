<?php
	session_start();
	include '../../configs/dbconfig.php';

	$user_id = $_SESSION['user_id'];

	if (isset($_GET['id'])){
		$id = $_GET['id'];
	} else {
		echo "Нет такого товара";
		die;
	}
	
	$link=mysqli_connect($host, $db_user, $db_password, $database);

	if(mysqli_connect_errno() ) {
		printf('Не удалось подключиться: %$\n', mysql_connect_error());
		exit();
	}


	$query="DELETE FROM posts WHERE Id='$id'";

	$result=mysqli_query($link, $query);

	if($result && $user_id)
		{
			header('Location: index.php');
		} else {
			header('Location: ../../login.php');
		}
		

	mysqli_close($link);
 ?>