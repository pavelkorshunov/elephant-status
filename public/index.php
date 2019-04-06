<?php
require '../config/config.php';
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use App\Parser\LinkParser;
use App\Validator\UriValidator;

//$body = file_get_contents(ROOTDIR . '/test.html');

// Указываем ресурс, который парсим
define("BASE_URL", "https://hard-skills.ru");
define("BASE_HOST", "hard-skills.ru");

$client = new Client([
    'base_uri' => BASE_URL
]);

$response = $client->request("GET", "/", ['http_errors' => false]);
$body = $response->getBody();
//echo $response->getStatusCode();



$parser = new LinkParser($body);

$links = $parser->parse();

$repeatLinks = [];

// Фильтруем ссылки по домену и валидности
foreach ($links as $link) {
    $validator = new UriValidator(BASE_HOST, $link['href']);

    if($validator->valid()) {
        array_push($repeatLinks, $link);
    }
}

// Формируем массив с путями
$linksPath = [];
foreach ($repeatLinks as $repeat) {
    $path = parse_url($repeat["href"], PHP_URL_PATH);
    array_push($linksPath, $path);
}

$pages = UriValidator::uniqueUrl($linksPath);

print_r($pages);
