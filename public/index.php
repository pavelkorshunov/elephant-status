<?php
require '../config/config.php';
require '../vendor/autoload.php';

use App\Parser\LinkParser;
use App\Validator\UriValidator;

$body = file_get_contents(ROOTDIR . '/test.html');

$parser = new LinkParser($body);

$links = $parser->parse();

foreach ($links as $link) {
    $validator = new UriValidator('links-errors.loc', $link['href']);

    if($validator->valid()) {
        print_r($link);
    }
}