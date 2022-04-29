<?php
declare(strict_types=1);

namespace Fyre\HTMLHelper;

use const
    ENT_HTML5,
    ENT_QUOTES,
    ENT_SUBSTITUTE;

use function
    array_search,
    count,
    htmlspecialchars,
    is_array,
    is_bool,
    is_numeric,
    is_object,
    json_encode,
    preg_match,
    preg_replace,
    strtolower,
    uksort;

/**
 * HtmlHelper
 */
class HtmlHelper
{

    protected static array $attributesOrder = [
        'class',
        'id',
        'name',
        'data-',
        'src',
        'for',
        'type',
        'href',
        'action',
        'method',
        'value',
        'title',
        'alt',
        'role',
        'aria-'
    ];

    protected static string $charset = 'UTF-8';

    /**
     * Generate an attribute string.
     * @param array $options The attributes.
     * @return string The attribute string.
     */
    public static function attributes(array $options = []): string
    {
        $attributes = [];

        foreach ($options AS $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_numeric($key)) {
                $key = $value;
                $value = null;
            }

            $key = preg_replace('/[^\w-]/', '', $key);
            $key = strtolower($key);

            if (!$key) {
                continue;
            }

            if (is_bool($value)) {
                $value = $value ? null : 'false';
            } else if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
                $value = static::escape($value);
            } else if ($value !== null) {
                $value = static::escape((string) $value);
            }

            $attributes[$key] = $value;
        }

        if ($attributes === []) {
            return '';
        }

        uksort($attributes, fn(string $a, string $b): int => static::attributeIndex($a) - static::attributeIndex($b));

        $html = '';

        foreach ($attributes AS $key => $value) {
            if ($value !== null) {
                $html .= ' '.$key.'="'.$value.'"';
            } else {
                $html .= ' '.$key;
            }
        }

        return $html;
    }

    /**
     * Escape characters in a string for use in HTML.
     * @param string $string The input string.
     * @return string The escaped string.
     */
    public static function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, static::$charset);
    }

    /**
     * Get the charset.
     * @return string $charset The charset.
     */
    public static function getCharset(): string
    {
        return static::$charset;
    }

    /**
     * Set the charset.
     * @param string $charset The charset.
     */
    public static function setCharset(string $charset): void
    {
        static::$charset = $charset;
    }

    /**
     * Get the index for an attribute.
     * @param string $attribute The attribute name.
     * @return int The attribute index.
     */
    protected static function attributeIndex(string $attribute): int
    {
        if (preg_match('/^(data|aria)-/', $attribute)) {
            $attribute = substr($attribute, 0, 5);
        }

        $index = array_search($attribute, static::$attributesOrder);

        if ($index === false) {
            return count(static::$attributesOrder);
        }

        return $index;
    }

}
