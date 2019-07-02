<?php
function getArticleList(){
    global $conn;
    $sql = "SELECT T.id, T.title, T.created, T.author_id, A.name
            FROM topic T, author A 
            WHERE T.author_id = A.id";
    $result = mysqli_query($conn, $sql);
    $list = '';
    while($row = mysqli_fetch_array($result)){

        $escaped_title = htmlspecialchars($row['title']);
        $escaped_author = htmlspecialchars($row['name']);
        $escaped_created = htmlspecialchars($row['created']);
        $list .=
        "<tr>".
            "<td>{$row['id']}</td>".
            "<td><a href=\"topic.php?id={$row['id']}\">$escaped_title</a></td>".
            "<td><a href=\"author.php?id={$row['author_id']}\">$escaped_author</a></td>".
            "<td>$escaped_created</td>".             
        "</tr>";
    }
    return $list;
}
function getArticle(){
    global $conn;
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);   // 필터링
    settype($filtered_id,'integer');
    $sql = "SELECT T.title, T.description, A.name, A.profile, I.save_name, I.origin_name, I.dir
            FROM topic T, author A, image I
            WHERE T.id = $filtered_id and T.author_id = A.id and T.image_id = I.id";
    
    // $sql = "SELECT a.title, a.description, c.name, c.profile, concat(c.save_name,'.',c.ext) as img, c.origin_name
    //         FROM topic as a
    //         left outer join image as b
    //         on a.image_id = b.id
    //         inner join author as c
    //         on a.author_id = c.id
    //         ";
 
    $result = mysqli_query($conn, $sql);
    $article;
    if ($row = mysqli_fetch_array($result)){
        $article = array(
            'title' => htmlspecialchars($row['title']),
            'description' => htmlspecialchars($row['description']),
            'name' => htmlspecialchars($row['name']),
            'save_img_name' => htmlspecialchars($row['save_name']),
            'origin_img_name' => htmlspecialchars($row['origin_name']),
            'dir' => htmlspecialchars($row['dir'])
        );
    }
    return $article;
}
function getBasicArticle(){
    return array(
        'title' => "WEB",
        'description' => "Hello World!",
        'name' => "anonym",
        'save_img_name' => "default.jpg",
        'origin_img_name' => "default.jpg"
    );
}
function getAuthorTableRows(){
    global $conn;
    $sql = "SELECT * FROM author";
    $result = mysqli_query($conn, $sql);
    $list = '';
    while($row = mysqli_fetch_array($result)){
        $escaped_id = htmlspecialchars($row['id']);
        $escaped_name = htmlspecialchars($row['name']);
        $escaped_profile = htmlspecialchars($row['profile']);
        $list .=
        "<tr>".
            "<td>$escaped_id</td>".
            "<td>$escaped_name</td>".
            "<td>$escaped_profile</td>".
            "<td><a href=\"author.php?id=$escaped_id\">수정</a></td>".     
            "<td>".
                "<form action=\"process/process_delete_author.php\" method=\"POST\" onsubmit=\"confirm('삭제하시겠습니까?')\">".
                    "<input type=\"hidden\" name=\"id\" value=\"$escaped_id\">".
                    "<input type=\"submit\" value=\"삭제\">".
                "</form>".
            "</td>".           
        "</tr>";
    }
    return $list;
}
function getAuthorList(){
    global $conn;
    $sql = "SELECT * FROM author";
    $result = mysqli_query($conn,$sql);
    $list = '<select name="author_id">';
    while($row = mysqli_fetch_array($result)){
        $escaped_name = htmlspecialchars($row['name']);
        $list .= "<option value=\"{$row['id']}\">$escaped_name</option>";
    }
    $list .="</select>";
    return $list;
}
function getAuthor(){
    global $conn;
    $filtered_id = mysqli_real_escape_string($conn, $_GET['id']);
    settype($filtered_id, 'integer');
    $sql = "SELECT * FROM author WHERE id = {$filtered_id}";
    $result = mysqli_query($conn, $sql);
    $filtered;
    if($row = mysqli_fetch_array($result)){
        $filtered['name'] = htmlspecialchars($row['name']);
        $filtered['profile'] = htmlspecialchars($row['profile']);
    } else {
        die("데이터를 가져오는 중 문제가 발생하였습니다. 관리자에게 문의해주세요");
    }
    return $filtered;
}
function getEmptyAuthor(){
    return array(
        'name'=>'',
        'profile'=>''
    );
}

?>