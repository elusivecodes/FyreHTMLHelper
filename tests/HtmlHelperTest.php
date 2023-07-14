<?php
declare(strict_types=1);

namespace Tests;

use Fyre\Utility\HtmlHelper;
use PHPUnit\Framework\TestCase;

final class HtmlHelperTest extends TestCase
{

    public function testAttributes(): void
    {
        $this->assertSame(
            ' href="#"',
            HtmlHelper::attributes([
                'href' => '#'
            ])
        );
    }

    public function testAttributesNumericKey(): void
    {
        $this->assertSame(
            ' disabled',
            HtmlHelper::attributes([
                'disabled'
            ])
        );
    }

    public function testAttributesTrue(): void
    {
        $this->assertSame(
            ' disabled',
            HtmlHelper::attributes([
                'disabled' => true
            ])
        );
    }

    public function testAttributesFalse(): void
    {
        $this->assertSame(
            ' disabled="false"',
            HtmlHelper::attributes([
                'disabled' => false
            ])
        );
    }

    public function testAttributesArray(): void
    {
        $this->assertSame(
            ' data-test="[1,2,3]"',
            HtmlHelper::attributes([
                'data-test' => [1, 2, 3]
            ])
        );
    }

    public function testAttributesOrder(): void
    {
        $this->assertSame(
            ' class="test" href="#"',
            HtmlHelper::attributes([
                'href' => '#',
                'class' => 'test'
            ])
        );
    }

    public function testAttributesEscape(): void
    {
        $this->assertSame(
            ' data-test="&quot;value&quot;"',
            HtmlHelper::attributes([
                'data-test' => '"value"'
            ])
        );
    }

    public function testAttributesEmpty(): void
    {
        $this->assertSame(
            '',
            HtmlHelper::attributes([])
        );
    }

    public function testEscape(): void
    {
        $this->assertSame(
            '&quot;',
            HtmlHelper::escape('"')
        );
    }

    public function testGetCharset(): void
    {
        $this->assertSame(
            'UTF-8',
            HtmlHelper::getCharset()
        );
    }

    public function testSetCharset(): void
    {
        HtmlHelper::setCharset('ISO-8859-1');

        $this->assertSame(
            'ISO-8859-1',
            HtmlHelper::getCharset()
        );
    }

    protected function setUp(): void
    {
        HtmlHelper::setCharset('UTF-8');
    }

}
