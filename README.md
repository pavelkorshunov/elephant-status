# ElephantStatus

ElephantStatus - библиотека для проверки кодов ответа страниц (ссылок) на сайте. Написана на языке программирования PHP. С ее помощью можно проверять страницы сайта на 404 ошибки или 301 редиректы.

# Установка

Установка с использованием [Composer](https://getcomposer.org/)

```bash
$ composer require elephant/status
```

Предварительно требуется убедиться, что в composer.json установлен `"minimum-stability": "alpha"` или `"minimum-stability": "dev"`

# Документация

Базовое использование

```php
use Elephant\Elephant;
use Elephant\Parser\SitemapParser;
use Elephant\Reports\DisplayReport;

$report = new DisplayReport();
$sitemap = new SitemapParser('sitemap.xml', false, true, 20);

$elephant = new Elephant([
    'base_uri' => 'https://foo.com',
    'parser' => $sitemap,
    'report' => $report
]);

$elephant->generateReport();
```

* **$sitemapPath** = sitemap.xml - путь к карте сайта. По умолчанию sitemap.xml, можно указать другой. Необязательный по умолчанию sitemap.xml.
* **$checkLinks** = false - требуется ли проверять ссылки в карте сайта на соответствие base_uri. Если true, то ссылки в карте сайта вида http://www.foo.ru или http://www.site.com проверяться не будут. Необязательный по умолчанию false.
* **$sitemapFollow** = true - требуется ли обходить другие ссылки карт сайта, если они нашлись в основном файле $sitemapPath. Необязательный по умолчанию false.
* **$maxLinks** = 2 - количество ссылок которые требуется проверить. Если не требуется ограничивать ставим 0, тогда проверит все ссылки. Необязательный по умолчанию 0.

## Примеры использования

Примеры использования можно найти в папке [samples](samples)
