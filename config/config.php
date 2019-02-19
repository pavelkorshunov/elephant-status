<?php
/*
 * Configuration file
 */

define("ROOTDIR", dirname(__DIR__));

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