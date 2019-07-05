<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <?php require("lib/common_files.php") ?>
    <script>  
    $(function(){

        $("#submit").on("click",function(){
            var formData1 = JSON.stringify($("#myForm").serialize());
            var formData2 = new FormData($("#myForm").get(0))
            var formData3 = {
                title : $("#title").val(),
                description : $("#description").val(),
                author_id : $("#author_id").val(),
                image_id : $("#image_id").val(),
            }
            
            // ajax(formData1);
        });

        function ajax(data){
            $.ajax({
                url : "http://localhost/sample/php_mysql/board/ver_api/api/topic/create.php",
                type : "post",
                dataType: "json",
                contentType : "application/json; charset=UTF-8",
                data : data,
                success : function(data){
                    console.log("성공")
                    console.log(data);
                },
                error : function(data){
                    console.log("실패");
                    console.log(data.responseText);
                }
            })
        }
    })
    </script>
</head>
<body>
    <form id="myForm">
        <input id="title" type="text" name="title" placeholder="title">
        <input id="description" type="text" name="description" placeholder="description">
        <input id="author_id" type="text" name="author_id" placeholder="author_id">
        <input id="image_id" type="text" name="image_id" placeholder="image_id">
        <button id="submit" type="button">전송</button>
    </form>
</body>
</html>