<?php
    require("config/connection.php");
    require("lib/func.php");

    // 전역 변수 설정
    $tableRows = getArticleList(); 
    $authors = getAuthorList();   

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>
    <link rel="stylesheet" href="css/topic.css">
    <script>
        $(function(){
            var $topic = $(".topic");
            var $btn_img = $(".btn_img");
            var $img_layer = $(".img_layer");
            var $layer_background = $(".layer_background");
            var $img_closer = $(".img_closer");

            $btn_img.on("click",function(){
                $img_layer.removeClass("hidden");
                $layer_background.removeClass("hidden");
            });
            $img_closer.on("click",function(){
                $img_layer.addClass("hidden");
                $layer_background.addClass("hidden");
            });
            
        });
    </script>
</head>
<body>
    <?php require("view/header.php") ?>

    <section class="topic create clearfix">
        <form enctype="multipart/form-data" action="process/process_create_topic.php" method="POST">
            <div class="topic_head clearfix">
                <div class="author fl-l">
                    <h3><span>작성자 : </span><?=$authors?></h3>
                </div>
            </div>
            <div class="tit clearfix">
                <h3 class="fl-l">
                    <input type="text" name="title" placeholder="제목을 입력해 주세요">
                </h3>
                
                <label class="btn_img fl-r">
                    <input type="file" name="myImage" accept="image/*" style="display:none" />
                </label>
                
            </div>
            <div class="description">
                <div class="textarea_box">
                    <textarea name="description" id="" cols="30" rows="10" placeholder="description"></textarea>
                </div>
            </div>
            <button type="submit">저장</button>
        </form>
    </section>

    <?php require("view/topicList.php") ?>

</body>
</html>
