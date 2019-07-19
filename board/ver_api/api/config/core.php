<?php

// show error reporting
ini_set("display_errors", 1);
error_reporting(E_ALL);

// home page url
$home_url = "http://localhost/sample/php_mysql/board/ver_api/api/";

// image directory
$uploads_dir = dirname(__DIR__).'/uploads';
$download_dir = "http://".$_SERVER['HTTP_HOST']."/sample/php_mysql/board/ver_api/api/uploads";

// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// set number of records per page
$records_per_page = 5;

// calculate for the query LIMIT clause
$from_record_num
    = ($records_per_page * $page) - $records_per_page; // 5 * ? - 5


?>