<?php

namespace MarkupKit\Tests;

use MarkupKit\Standard\Components\Component;
use MarkupKit\Standard\Components\Image;
use MarkupKit\Standard\Components\ItemList;
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
        $this->assertInstanceOf(AttributedSubstring::class, $components[0]->content->elements[0]);
        $this->assertEquals('Bold text', $components[0]->content->elements[0]->string);

        $this->assertInstanceOf(Image::class, $components[1]);
        $this->assertEquals('https://example.org/dummy.jpg', $components[1]->src);
        $this->assertEquals('https://example.org/full.jpg', $components[1]->link);

        $this->assertInstanceOf(Text::class, $components[2]);
    }

    public function testWithQuote(): void
    {
        $html = '<blockquote>Quoted text</blockquote>';
        $components = self::$parser->parse($html, self::$options);
        $this->assertCount(1, $components);
        $this->assertInstanceOf(Text::class, $components[0]);
        $this->assertEquals(Text\Style::Quote, $components[0]->style);
        $this->assertEquals('Quoted text', (string)$components[0]->content);
    }

    public function testWithPreformatted(): void
    {
        $html = '<pre>     Preformatted    text     </pre>';
        $components = self::$parser->parse($html, self::$options);
        $this->assertCount(1, $components);
        $this->assertInstanceOf(Text::class, $components[0]);
        $this->assertEquals(Text\Style::Preformatted, $components[0]->style);
        $this->assertEquals('     Preformatted    text     ', (string)$components[0]->content);
    }

    public function testWithList(): void
    {
        $html = '<ul><li>Item 1</li><li>Item 2</li></ul>';
        $components = self::$parser->parse($html, self::$options);
        $this->assertCount(1, $components);
        $this->assertInstanceOf(ItemList::class, $components[0]);
        $this->assertCount(2, $components[0]->items);
        $this->assertCount(1, $components[0]->items[0]->content);
        $this->assertInstanceOf(Text::class, $components[0]->items[0]->content[0]);
        $this->assertEquals('Item 1', (string)$components[0]->items[0]->content[0]->content);
    }
}
