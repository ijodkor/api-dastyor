# API dastyor

Laravel dastyor, loyihani bir zumda qurishga yordam beradi

## Talablar (Requirements)

- PHP ^8.2
- Laravel ^11

## Talqinlar mutonosibligi (Version Compatibility)

| Laravel | Laravel Generator | 
|:--------|:------------------|
| 11.x    | 1.2.x             |

## O&#8216;rnatish (Installation)

Install the package via composer:

```bash
composer require ijodkor/api-dastyor
```

## Ishlatish (Usage)

1. Media fayllar public papkaga chiqariladi

```php
php artisan vendor:publish --provider="Uzinfocom\Dastyor\MainServiceProvider"
```

2. ``/dastyor`` Manziliga o&#8216;tiladi.

## Foydalanilgan manbalar (References)

- [Testbench](https://packages.tools/testbench) Laravel Testing Helper for Packages Development

### Foydali havolalar (Links)

- [PHP-FIG](https://www.php-fig.org/)
- [Create Laravel package](https://laravel-news.com/building-your-own-laravel-packages)
- [Create package](https://medium.com/@prevailexcellent/how-i-created-my-third-laravel-package-step-by-step-guide-ad3fb0da5399)
- [Publish assets](https://freek.dev/424-publishing-package-assets-the-right-way)
- [Read file as lines](https://code.tutsplus.com/read-a-file-line-by-line-with-php--cms-92971t)
- [Add item to any index](https://www.geeksforgeeks.org/program-to-insert-new-item-in-array-on-any-position-in-php/)
- [Right trim](https://www.php.net/manual/en/function.rtrim.php)
