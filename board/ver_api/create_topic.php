
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>
    <link rel="stylesheet" href="css/topic.css">
    <script>
        $(function(){

            // get author list
            $.ajax({
                url : "http://localhost/sample/php_mysql/board/ver_api/api/author/read.php",
                method : "get",
                success : function(data){   
                    var authors = data.records;
                    var options;
                    for(var i=0; i < authors.length; i++){
                        options +=
                        '<option value="' + authors[i].id + '">' + authors[i].name + '</option>';
                    }
                    $("#authors").append(options);
                },
                error : function(){
                    console.log("error");
                }

            });
            


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
    <?php require("fragments/header.php") ?>

    <section class="topic create clearfix">
        <form action="process/process_create_topic.php" method="POST">
            <div class="topic_head clearfix">
                <div class="author fl-l">
                    <h3>
                        <span>작성자 : </span>
                        <select name="" id="authors">

                        </select>
                    </h3>
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


</body>
</html>
