<?php

    include '../task2/configs/dbconfig.php';

    $link=mysqli_connect($host, $db_user, $db_password, $database);

    $query="SELECT users.first_name, posts.title, posts.description, posts.id FROM `posts` JOIN users ON posts.user_id=users.id";

    $result = mysqli_query($link,$query);

    if($result){
        while ($row = $result->fetch_assoc()) {
            $posts[]=$row; 
        }

        $result->close();
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
          
            <h1>Список новостей</h1>
            <div class="btn">
                <a class="btn__link" href="task/login.php">Войти</a>
            </div>          
            <div class="news">
            <?php if (isset($posts)): ?>
                <?php
                    foreach ($posts as $post) {
                ?> 
                    <div>
                        <div>Название статьи:<a href="item.php?id=<?php echo $post['id'];?>"><?php echo $post['title']; ?></a></div>
                        <div>Автор:<?php echo $post['first_name']; ?></div>
                        <div>Описание:<?php echo $post['description']; ?></div>
                        <hr>
                    </div>
            <?php
                    }
                ?>
            </div>
            <?php else: ?>
            <p>Нет новостей</p>
            <?php endif;?>


        </div>
    </div>

</body>
</html>