<?php

    include 'configs/dbconfig.php';

    $link=mysqli_connect($host, $user, $password, $database);

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    } else {
        echo "Нет такого товара";
        die;
    }

    $query="SELECT * FROM posts WHERE id='$id'";

    $result = mysqli_query($link,$query);

    if($result && mysqli_num_rows($result)>0){
        $post=$result->fetch_assoc();
        mysqli_free_result($result);
    }

    mysqli_close($link);
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
    <div class="products__inner">
        <div class="container">
            <a href="index.php">Назад</a>
            <h1><?php echo $post['title']; ?></h1>
            <div class="btn">
                <a class="btn__link" href="login.php">Войти</a>
            </div>          
            <div class="news">
                    <div>
                        <div>Название статьи:<?php echo $post['title']; ?></div>
                        <div>Текст:<?php echo $post['text']; ?></div>
                    </div>
            </div>

        </div>
    </div>

</body>
</html>