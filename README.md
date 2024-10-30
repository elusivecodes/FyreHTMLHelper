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

```php
$html = new HtmlHelper();
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