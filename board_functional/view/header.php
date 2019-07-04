<?php
    function startsWith($haystack, $needle){
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    preg_match("`\/[^/]*\.php$`i", $_SERVER['PHP_SELF'], $matches);
    $now = $matches[0];
    $elHome = '<a href="index.php">HOME</a>';
    $elTopic = (startsWith($now,"/topic"))  
                ? '<li class="on"><a href="topic.php">TOPIC</a></li>'
                : '<li><a href="topic.php">TOPIC</a></li>';
    $elAuthor = (startsWith($now,"/author")) 
                ? '<li class="on"><a href="author.php">AUTHOR</a></li>' 
                : '<li><a href="author.php">AUTHOR</a></li>';
  
?>
<style>
   header{
        height: 50px;
        margin-bottom:10px;
        background-color: #449274;
    }
    header nav{
        width:1050px;
        margin:0 auto;
    }
    header h1{
        float: left;
        width:120px;
        height:30px;
        margin-top:10px;
        color:#fff;
        text-align:center;
        font-size:26px;
        font-weight:800;
    }
    header ul{
        float: left;
        margin-top:13px;
    }
    header ul li{
        float: left;
        width:90px;
        padding:3px 0 5px;
        margin-right:5px;
        text-align:center;
        font-size:18px;
        
    }
    header ul li:hover,
    header ul li.on{
        background-color:#fff;
        border-radius:4px;
    }
    header ul li:hover a,
    header ul li.on a{
        color:#449274;
    }
</style>
<header>
    <nav class="clearfix">
        <h1><?=$elHome?></h1>
        <ul class="clearfix">
            <?=$elTopic?>
            <?=$elAuthor?>
        </ul>
    </nav>
</header>