<?php
	session_start();
	include '../../configs/dbconfig.php';


	if (isset($_GET['id'])){
		$id = $_GET['id'];
		$link=mysqli_connect($host, $db_user, $db_password, $database);

		$query="DELETE FROM posts WHERE Id='$id'";

		$result=mysqli_query($link, $query);
	
		if($result)
			{
				header('Location: index.php');
			} else {
				header('Location: ../../login.php');
			}
			
	
		mysqli_close($link);

	} else {
		echo "Нет такого товара";
		die;
	}
	
	if(mysqli_connect_errno() ) {
		printf('Не удалось подключиться: %$\n', mysql_connect_error());
		exit();
	}

 ?>