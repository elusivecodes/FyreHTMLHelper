# FyreHTMLHelper

**FyreHTMLHelper** is a free, open-source HTML helper library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [Methods](#methods)



## Installation

**Using Composer**

```
composer require fyre/htmlhelper
```

In PHP:

```php
use Fyre\Utility\HtmlHelper;
```


## Basic Usage

- `$config` is a [*Config*](https://github.com/elusivecodes/FyreConfig).

```php
$html = new HtmlHelper($config);
```

The default character set will be resolved from the "*App.charset*" key in the *Config*.

**Autoloading**

It is recommended to bind the *HtmlHelper* to the [*Container*](https://github.com/elusivecodes/FyreContainer) as a singleton.

```php
$container->singleton(HtmlHelper::class);
```

Any dependencies will be injected automatically when loading from the [*Container*](https://github.com/elusivecodes/FyreContainer).

```php
$html = $container->use(HtmlHelper::class);
```


## Methods

**Attributes**

Generate an attribute string.

- `$options` is an array containing the attributes.

```php
$attributes = $html->attributes($options);
```

**Escape**

Escape characters in a string for use in HTML.

- `$string` is the string to escape.

```php
$escaped = $html->escape($string);
```

**Get Charset**

Get the character set.

```php
$charset = $html->getCharset();
```

**Set Charset**

Set the character set.

- `$charset` is a string representing the character set.

```php
$html->setCharset($charset);
```