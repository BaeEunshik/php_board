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
                id : $("#id").val(),
                title : $("#title").val(),
                description : $("#description").val()
            }
            ajax(JSON.stringify(formData3));
        });

        function ajax(data){
            $.ajax({
                url : "http://localhost/sample/php_mysql/board/ver_api/api/topic/update.php",
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
        <input id="id" type="text" name="id" placeholder="id">
        <input id="title" type="title" name="id" placeholder="title">
        <input id="description" type="text" name="description" placeholder="description">
        <button id="submit" type="button">전송</button>
    </form>
</body>
</html>