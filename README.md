# ElephantStatus

ElephantStatus - библиотека для проверки кодов ответа страниц (ссылок) на сайте. Написана на языке программирования PHP.

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
$sitemap = new SitemapParser('sitemap.xml', false, 2);

$elephant = new Elephant([
    'base_uri' => 'https://foo.com',
    'parser' => $sitemap,
    'report' => $report
]);

$elephant->generateReport();
```

## Примеры использования

Примеры использования можно найти в папке [samples](samples)
