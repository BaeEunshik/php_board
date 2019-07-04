<?php
    require_once("config/connection.php");
    require_once("lib/func.php");
    
    // get a topic
    $article = (isset($_GET['id'])) ? getArticle() : getBasicArticle();
    if($article === NULL){ 
        header("Location: topic.php"); 
    }

    // set elements
    $update_link = (isset($_GET['id'])) ? '<a class="btn btn_update fl-r" href="update_topic.php?id='.$_GET['id'].'">update</a>' : '';
    $delete_link = (isset($_GET['id'])) ? 
        '<form class="form_delete fl-r" action="process/process_delete_topic.php" method="POST" onsubmit="return confirm(\'삭제하시겠습니까?\');" style="display:inline-block">
            <input type="hidden" name="id" value="'.$_GET['id'].'">
            <button class="btn btn_delete" type="submit">delete</button>
        </form>' : '';

    // topic info 
    $title = $article['title'];
    $description = $article['description'];
    $author_name = $article['name'];
    $save_img_name = $article['save_img_name'];
    $origin_img_name = $article['origin_img_name'];
    $dir = $article['dir'];

    $img_location = "$dir/$save_img_name";
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
            $btn_img.on("click.imgEvt",function(){
                imgResize();
                $(this).off("click.imgEvt");
            });
            $img_closer.on("click",function(){
                $img_layer.addClass("hidden");
                $layer_background.addClass("hidden");
            });
            

            function imgResize(){
                // 이미지 비율 로직 
                var div = document.getElementsByClassName("img_container")[0];
                var img = div.getElementsByTagName("img")[0];
                var divAspect = 40 / 60;
                var imgAspect = img.height / img.width;
                
                // 이미지가 div보다 납작한 경우 가로폭을 맞춘다.            
                if (imgAspect <= divAspect) {
                    var divHeight = div.style.height.replace("px","");
                    var divWidth = div.style.width.replace("px","");
                    var adjustImgHeight = img.height * ( divWidth / img.width ) ;   
                    var paddingTop = (divHeight - adjustImgHeight) / 2;
                    img.style.cssText = 'width:100%; height:auto;';
                    div.style.paddingTop = paddingTop + 'px';
                } else {
                    img.style.cssText = 'width:auto; height:100%; margin:0 auto;';
                }
            }
        });
    </script>
</head>
<body>
    <?php require("view/header.php") ?>
    
    <?php if(isset($_GET['id'])) {?>
    <section class="topic clearfix">
        <div class="topic_head clearfix">
            <div class="author fl-l">
                <h3>
                    <span>작성자 : </span>
                    <span id="author_name">
                        <?=$author_name?>
                    </span>
                </h3>
            </div>
            <div class="btns fl-r clearfix">
                <?=$delete_link?>
                <?=$update_link?>
            </div>
        </div>
        <div class="tit clearfix">
            <h3 class="fl-l">
                <?=$title?>
            </h3>
            <span class="btn_img fl-r"></span>

            <div class="layer_background img_closer hidden" style="position:fixed;left:0;top:0;width:100%; height:100%; background-color:rgba(0,0,0,0.7)"></div>
            <div class="img_layer hidden" 
            style="width:600px;top:50px;left:50%;margin-left:-300px;z-index: 11;">
                <div id="img_container" class="img_container" style="width:600px; height:400px">
                    <button class="close img_closer" style="position:absolute;right:5px;top:5px;width:20px;height:20px;padding:0;background:none"></button>
                    <img id="img" src="<?=$img_location?>" alt="">
                </div>
            </div>
        </div>
        <div class="description">
            <p><?=$description?></p>
        </div>
    </section>
    <?php } ?>
    
    <div class="btns">
        <a class="btn btn_create" href="create_topic.php">create</a>
    </div>
    
    <?php require("view/topicList.php") ?>
    
</body>
</html>