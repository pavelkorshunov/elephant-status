<?php
require '../config/config.php';
require '../vendor/autoload.php';

use App\Parser\LinkParser;

$body = file_get_contents(ROOTDIR . '/test.html');

$parser = new LinkParser($body);

print_r($parser->parse());