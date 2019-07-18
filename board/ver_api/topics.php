<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>
    <link rel="stylesheet" href="css/topics.css">
    <script>
        $(function(){
            
            $.ajax({
                url : "http://localhost/sample/php_mysql/board/ver_api/api/topic/read.php",
                method : "GET",
                success : function(data){
                    setTopics(data.records);
                },
                error : function(){
                    console.log("error");
                }
            });

            function setTopics(topics){
                var row;
                var topic;
                for(var i=0; i < topics.length; i++){
                    topic = topics[i];
                    row += '<tr>' +
                            '<td>'+ topic.id +'</td>' +
                            '<td><a href="topic.php?id=' + topic.id + '">' + topic.title + '</a></td>' +
                            '<td><a href="author.php?id=' + topic.author_id +'">' + topic.author_name + '</a></td>' +
                            '<td>' + topic.created + '</td>' +
                        '</tr>'
                }
                $("#topics").append(row);
            }
                        
        });
    </script>
</head>
<body>
    <?php require("fragments/header.php") ?>
    <section class="topic_list">
        <table>
            <colgroup>
                <col style="width:5%">
                <col style="width:60%">
                <col style="width:15%">
                <col style="width:15%">
            </colgroup>
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>작성자</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody id="topics">
                
            </tbody>
        </table>
    </section>
    
</body>
</html>