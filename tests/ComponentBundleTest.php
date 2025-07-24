<?php

namespace MarkupKit\Tests;

use MarkupKit\Standard\Components\Component;
use MarkupKit\Standard\Components\Image;
use MarkupKit\Standard\Components\Text;
use MarkupKit\Standard\Parsers\ComponentBundle;
use MarkupKit\Core\String\AttributedSubstring;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use PHPUnit\Framework\TestCase;

class ComponentBundleTest extends TestCase
{
    /**
     * @var Parser
     */
    private static Parser $parser;

    /**
     * @var Options<Component>
     */
    private static Options $options;

    public static function setUpBeforeClass(): void
    {
        self::$parser = new Parser();
        self::$options = new Options(nodeParsers: new ComponentBundle());
    }

    public function testWithOnlyText(): void
    {
        $html = '<strong>Bold text</strong> and <em>italic text</em>';
        $components = self::$parser->parse($html, self::$options);
        $this->assertCount(1, $components);
        $this->assertInstanceOf(Text::class, $components[0]);
    }

    public function testWithImage(): void
    {
        $html = '<strong>Bold text</strong>, <a href="https://example.org/full.jpg">an image <img src="https://example.org/dummy.jpg"></a> and <em>italic text</em>';
        $components = self::$parser->parse($html, self::$options);
        $this->assertCount(3, $components);

        $this->assertInstanceOf(Text::class, $components[0]);
        $this->assertInstanceOf(AttributedSubstring::class, $components[0]->string->elements[0]);
        $this->assertEquals('Bold text', $components[0]->string->elements[0]->string);

        $this->assertInstanceOf(Image::class, $components[1]);
        $this->assertEquals('https://example.org/dummy.jpg', $components[1]->src);
        $this->assertEquals('https://example.org/full.jpg', $components[1]->link);

        $this->assertInstanceOf(Text::class, $components[2]);
    }
}
