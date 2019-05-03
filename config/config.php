<?php
/*
 * Configuration file
 */

define("ROOTDIR", dirname(__DIR__));
// Указываем ресурс, который парсим
define("BASE_URL", "https://hard-skills.ru");
define("BASE_HOST", "hard-skills.ru");

/**
 * @param  mixed  $print
 * @return mixed
 */
function dumpd($print)
{
    if(is_array($print) || is_object($print)) {
        echo "<pre>" . print_r($print) . "</pre>";
    }
    else {
        var_dump($print);
    }
    die();
}