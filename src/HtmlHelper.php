<?php
declare(strict_types=1);

namespace Fyre\Utility;

use Fyre\Config\Config;
use Fyre\Utility\Traits\MacroTrait;

use function array_search;
use function count;
use function htmlspecialchars;
use function is_array;
use function is_bool;
use function is_numeric;
use function is_object;
use function json_encode;
use function preg_match;
use function preg_replace;
use function strtolower;
use function uksort;

use const ENT_HTML5;
use const ENT_QUOTES;
use const ENT_SUBSTITUTE;

/**
 * HtmlHelper
 */
class HtmlHelper
{
    use MacroTrait;

    protected const ATTRIBUTES_ORDER = [
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
        'aria-',
    ];

    protected string $charset = 'UTF-8';

    /**
     * New HtmlHelper constructor.
     *
     * @param Config $config The Config.
     */
    public function __construct(Config $config)
    {
        $this->charset = $config->get('App.charset', 'UTF-8');
    }

    /**
     * Generate an attribute string.
     *
     * @param array $options The attributes.
     * @return string The attribute string.
     */
    public function attributes(array $options = []): string
    {
        $attributes = [];

        foreach ($options as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_numeric($key)) {
                $key = $value;
                $value = null;
            }

            $key = preg_replace('/[^\w\-:.@]/', '', $key);
            $key = strtolower($key);

            if (!$key) {
                continue;
            }

            if (is_bool($value)) {
                $value = $value ? null : 'false';
            } else if (is_array($value) || is_object($value)) {
                $value = json_encode($value);
                $value = $this->escape($value);
            } else if ($value !== null) {
                $value = $this->escape((string) $value);
            }

            $attributes[$key] = $value;
        }

        if ($attributes === []) {
            return '';
        }

        uksort($attributes, fn(string $a, string $b): int => static::attributeIndex($a) <=> static::attributeIndex($b));

        $html = '';

        foreach ($attributes as $key => $value) {
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
     *
     * @param string $string The input string.
     * @return string The escaped string.
     */
    public function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5, $this->charset);
    }

    /**
     * Get the charset.
     *
     * @return string $charset The charset.
     */
    public function getCharset(): string
    {
        return $this->charset;
    }

    /**
     * Set the charset.
     *
     * @param string $charset The charset.
     * @return static The HtmlHelper.
     */
    public function setCharset(string $charset): static
    {
        $this->charset = $charset;

        return $this;
    }

    /**
     * Get the index for an attribute.
     *
     * @param string $attribute The attribute name.
     * @return int The attribute index.
     */
    protected static function attributeIndex(string $attribute): int
    {
        if (preg_match('/^(data|aria)-/', $attribute)) {
            $attribute = substr($attribute, 0, 5);
        }

        $index = array_search($attribute, static::ATTRIBUTES_ORDER);

        if ($index === false) {
            return count(static::ATTRIBUTES_ORDER);
        }

        return $index;
    }
}
