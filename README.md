# FyreHTMLHelper

**FyreHTMLHelper** is a free, HTML helper library for *PHP*.


## Table Of Contents
- [Installation](#installation)
- [Methods](#methods)



## Installation

**Using Composer**

```
composer require fyre/htmlhelper
```

In PHP:

```php
use Fyre\HTMLHelper\HtmlHelper;
```


## Methods

**Attributes**

Generate an attribute string.

- `$options` is an array containing the attributes.

```php
$attributes = HtmlHelper::attributes($options);
```

**Escape**

Escape characters in a string for use in HTML.

- `$string` is the string to escape.

```php
$escaped = HtmlHelper::escape($string);
```

**Get Charset**

Get the character set.

```php
$charset = HtmlHelper::getCharset();
```

**Set Charset**

Set the character set.

- `$charset` is a string representing the character set.

```php
HtmlHelper::setCharset($charset);
```