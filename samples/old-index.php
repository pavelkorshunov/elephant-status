<?php
require '../vendor/autoload.php';

//use App\Parser\LinkParser;
//use App\Validator\UriValidator;
//require '/config/config.php';
//$body = file_get_contents(ROOTDIR . '/test.html');
//$client = RequestClient::getInstance();
//
//$response = $client->request("GET", "/", ['http_errors' => false]);
//$body = $response->getBody();
////echo $response->getStatusCode();
//
//
//$parser = new LinkParser($body);
//
//$links = $parser->parse();
//
//$repeatLinks = [];
//
//// Фильтруем ссылки по домену и валидности
//foreach ($links as $link) {
//    $validator = new UriValidator(BASE_HOST, $link['href']);
//
//    if($validator->valid()) {
//        array_push($repeatLinks, $link);
//    }
//}
//
//// Формируем массив с путями
//$linksPath = [];
//foreach ($repeatLinks as $repeat) {
//    $path = parse_url($repeat["href"], PHP_URL_PATH);
//    array_push($linksPath, $path);
//}
//
//$pages = UriValidator::uniqueUrl($linksPath);
//
//print_r($pages);