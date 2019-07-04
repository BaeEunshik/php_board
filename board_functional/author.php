
<?php
    require("config/connection.php");
    require("lib/func.php");

    // 전역 변수 설정
    $tableRows = getAuthorTableRows();
    $isUpdate = isset($_GET['id']);
    $author = ($isUpdate) ? getAuthor() : getEmptyAuthor();
    $label_submit = ($isUpdate) ? "Update Author" : "Create Author";
    $form_action = ($isUpdate) ? "process/process_update_author.php" : "process/process_create_author.php";
    $form_id = ($isUpdate) ? '<input type="hidden" name="id" value="'.$_GET['id'].'">' : "";

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>WEB</title>
    <?php require("lib/common_files.php") ?>

</head>
<body>
    <?php require("view/header.php") ?>

    <table>
        <thead>
            <tr>
                <th>id</th>
                <th>name</th>
                <th>profile</th>
                <th>update</th>
                <th>delete</th>
            </tr>
        </thead>
        <tbody>
            <?=$tableRows?>
        </tbody>
    </table>
    <form action="<?=$form_action?>" method="POST">
        <?=$form_id?>
        <p><input type="text" name="name" placeholder="name" value="<?=$author['name']?>"></p>
        <p><textarea name="profile" id="" cols="30" rows="10" placeholder="profile"><?=$author['profile']?></textarea></p>
        <input type="submit" value="<?=$label_submit?>">
    </form>
</body>
</html>
