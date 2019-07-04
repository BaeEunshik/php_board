<?php
    require("config/connection.php");
    require("lib/func.php");
    
    // 전역 변수 설정
    $article = (isset($_GET['id'])) ? getArticle() : getBasicArticle();
    $update = (isset($_GET['id'])) ? '<a href="update_topic.php?id='.$_GET['id'].'">update</a>' : '';

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>
    <link rel="stylesheet" href="css/topic.css">

</head>
<body>
    <?php require("view/header.php") ?>

    <form action="process/process_update_topic.php" method="POST">
        <input type="hidden" name="id" value="<?=$_GET['id']?>">
        <p><input type="text" name="title" placeholder="title" value="<?=$article['title']?>"></p>
        <p><textarea name="description" id="" cols="30" rows="10" placeholder="description"><?=$article['description']?></textarea></p>
        <input type="submit">
    </form>
   
    <?php require("view/topicList.php") ?>

</body>
</html>
