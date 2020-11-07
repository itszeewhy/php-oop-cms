<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.css">
    <title>
        <?php
        $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        if (strpos($url, "?") !== false) {
            $url_ext = ".php?";
        } else {
            $url_ext = ".php";
        }
        $title = basename($url, $url_ext . parse_url($url, PHP_URL_QUERY));
        echo ($title == "index") ? "Home" : ucfirst($title);
        ?>
    </title>
</head>

<body>
    <?php
    include 'classloader.inc.php';
    ob_start();
    session_start();
    ?>