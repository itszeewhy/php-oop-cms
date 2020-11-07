<?php

spl_autoload_register("classLoader");

function classLoader($className)
{

    $url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $extension = ".class.php";

    if (strpos($url, "includes") !== false) {
        $path = "../classes/";
    } else {
        $path = "classes/";
    }

    require_once $path . $className . $extension;
}
