<?php
    require_once("config/connection.php");
    require_once("lib/func.php");
    $tableRows = getArticleList();
?>
<style>
.topic_list{
    padding-bottom: 25px;
    width: 1024px;
    margin:0 auto;
}
.topic_list table{
    width: 100%;
    background-color:#fff;
}
.topic_list table tr th,
.topic_list table tr td {
    height: 25px;
    font-size:13px;
    vertical-align: middle;
    border: 1px solid #000;
    color: #000;
}
.topic_list table tr td:nth-child(1),
.topic_list table tr td:nth-child(3),
.topic_list table tr td:nth-child(4){
    text-align:center;
}
.topic_list table tr td:nth-child(2){
    text-indent:10px;
}
.topic_list table tr td a{
    color: #000;
}
.topic_list table tr td a:hover{
    color:cornflowerblue;
}
</style>
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
        <tbody>
            <?=$tableRows?>
        </tbody>
    </table>
</section>