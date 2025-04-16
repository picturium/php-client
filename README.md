# picturium client

PHP client library for [https://github.com/picturium/picturium](picturium) image server.


## Install

```bash
composer require lamka02sk/picturium
```

Then configure your picturium server instance. You can also configure multiple picturium instances at once and then pass name of the instance you want to use to constructor or `PicturiumImage` `src` and `srcset` methods.

```php
Picturium/Picturium::configure("instance name", "http://127.0.0.1:20045/", "KEY from picturium server .env")
```


## Usage

Autoloads `src/picturium.php` file that provides global functions for simple and quick image URL generation.

### Function `pic(...)`

Returns `Picturium` class instance that can be used to manage complex generation of responsive images with different sizes for different screen resolutions.

### Function `img(...)`

Function returns `PicturiumImage` instance with configured image resource ready for `src`, `srcset` or `media` attribute generation.

### Function `image(...)`

Basically the same as `img`. Just in case one of these 2 functions already existed in your app :)
