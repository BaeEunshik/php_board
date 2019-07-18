<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>
    <link rel="stylesheet" href="css/topic.css">
    <script>
        $(function(){

            var url = new URL(window.location.href);
            var topic_id = url.searchParams.get("id");
            $.ajax({
                url : "http://localhost/sample/php_mysql/board/ver_api/api/topic/read_one.php?id=" + topic_id,
                method : "GET",
                success : function(data){
                    $("#author_name").text(data.author_name);
                    $("#title").text(data.title);
                    $("#img_container").append('<img id="img" src="' + data.image_file + '" alt="">');
                    $("#description").text(data.description);
                    console.log(data);
                },
                errror : function(){

                }
            })

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
    <?php require("fragments/header.php") ?>
    
    <section class="topic clearfix">
        <div class="topic_head clearfix">
            <div class="author fl-l">
                <h3>
                    <span>작성자 : </span>
                    <span id="author_name">
                    </span>
                </h3>
            </div>
            <div class="btns fl-r clearfix">
            </div>
        </div>
        <div class="tit clearfix">
            <h3 id="title" class="fl-l"></h3>
            <span class="btn_img fl-r"></span>

            <div class="layer_background img_closer hidden" style="position:fixed;left:0;top:0;width:100%; height:100%; background-color:rgba(0,0,0,0.7)"></div>
            <div class="img_layer hidden" 
            style="width:600px;top:50px;left:50%;margin-left:-300px;z-index: 11;">
                <div id="img_container" class="img_container" style="width:600px; height:400px">
                    <button class="close img_closer" style="position:absolute;right:5px;top:5px;width:20px;height:20px;padding:0;background:none"></button>
                    
                </div>
            </div>

        </div>
        <div class="description">
            <p id="description"></p>
        </div>
    </section>
    
    <div class="btns">
        <a class="btn btn_create" href="create_topic.php">create</a>
    </div>
    
</body>
</html>