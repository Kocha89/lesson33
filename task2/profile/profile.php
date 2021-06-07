<?php
    session_start();

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
            <?php if($_SESSION['result']){
                echo "Привет, " . $_SESSION['first_name'] . " .Добро пожаловать в личный кабинет."; 
                } else {
                //  $message = "Invalid username or password!";
                
                echo  "Invalid username or password!";

             } ?>
            <div>
                <p>Имя: <?php echo $_SESSION['first_name'];?></p>
                <p>Фамилия: <?php echo $_SESSION['last_name'];?></p>            
                <div class="btn">
                    <a class="btn__link" href="update.php?id=<?php echo $_SESSION['id'];?>">Изменить</a>
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
                    unset($_SESSION['email']);
                    unset($_SESSION['password']);
                    session_destroy();
                    header("location:../login.php"); ?>
            <?php endif;?>
        </div>
    </div>
</body>
</html>
