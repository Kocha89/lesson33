<?php
    session_start();
    include '../configs/dbconfig.php';


    $link=mysqli_connect($host, $user, $password, $database);


    $email=$_SESSION['email'];
    $password=$_SESSION['password'];
  

    $query="SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($link,$query);


    if($result && mysqli_num_rows($result)>0){
        $row=$result->fetch_assoc();
        $_SESSION['id']=$row['id'];

    }


    mysqli_close($link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <div class="form">
        <div class="container">
            <?php if (isset($_SESSION['email']) && isset($_SESSION['password'])): ?>
            <div class="form__inner2">
            <div class="registration2">
            <h2>Личный кабинет</h2>
            <?php if($result){
                echo "Привет, " . $row['first_name'] . " .Добро пожаловать в личный кабинет."; 
                } else {
                //  $message = "Invalid username or password!";
                
                echo  "Invalid username or password!";

             } ?>
            <div>
                <p>Имя: <?php echo $row['first_name'];?></p>
                <p>Фамилия: <?php echo $row['last_name'];?></p>            
                <div class="btn">
                    <a class="btn__link" href="update.php?id=<?php echo $row['id'];?>">Изменить</a>
                </div>
                
            </div>
            <div class="btn">
                <a class="btn__link" href="posts/index.php">Список новостей</a>
            </div>
            <div class="btn">
                <a class="btn__link" href="../logout.php">Выйти</a>
            </div>
            <div>
            </div>
            </div>
            </div>
            <?php else:
                    session_start();
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    session_destroy();
                    header("location:../login.php"); ?>
            <?php endif;?>
        </div>
    </div>
</body>
</html>
