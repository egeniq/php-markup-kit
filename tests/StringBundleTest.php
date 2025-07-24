<?php

namespace MarkupKit\Tests;

use MarkupKit\Standard\Parsers\StringBundle;
use MarkupKit\Standard\String\FormatAttribute;
use MarkupKit\Standard\String\ImageAttachment;
use MarkupKit\Standard\String\LinkAttribute;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedSubstring;
use PHPUnit\Framework\TestCase;

class StringBundleTest extends TestCase
{
    private static Parser $parser;

    public static function setUpBeforeClass(): void
    {
        self::$parser = new Parser();
    }

    private function parseAttributedString(
        string $html,
        bool $preserveWhitespace = false,
        bool $trimWhitespaceAroundAttachments = false,
    ): AttributedString {
        $bundle = new StringBundle(
            preserveWhitespace: $preserveWhitespace,
            trimWhitespaceAroundAttachments: $trimWhitespaceAroundAttachments
        );

        $components = self::$parser->parse($html, new Options(nodeParsers: $bundle));
        $this->assertCount(1, $components);
        return $components[0];
    }

    public function testFormatting(): void
    {
        $html = '<strong>Bold text</strong> and <em>italic text</em>';
        $string = $this->parseAttributedString($html);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('Bold text', $string->elements[0]->string);
        $this->assertCount(1, $string->elements[0]->attributes);
        $this->assertTrue($string->elements[0]->attributes->hasAttribute(FormatAttribute::Bold));

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[1]);
        $this->assertEquals(' and ', $string->elements[1]->string);
        $this->assertCount(0, $string->elements[1]->attributes);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals('italic text', $string->elements[2]->string);
        $this->assertCount(1, $string->elements[2]->attributes);
        $this->assertTrue($string->elements[2]->attributes->hasAttribute(FormatAttribute::Italic));
    }

    public function testMixedFormatting(): void
    {
        $html = '<strong>Bold and <em>italic</em> text</strong>';
        $string = $this->parseAttributedString($html);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('Bold and ', $string->elements[0]->string);
        $this->assertCount(1, $string->elements[0]->attributes);
        $this->assertTrue($string->elements[0]->attributes->hasAttribute(FormatAttribute::Bold));

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[1]);
        $this->assertEquals('italic', $string->elements[1]->string);
        $this->assertCount(2, $string->elements[1]->attributes);
        $this->assertTrue($string->elements[1]->attributes->hasAttribute(FormatAttribute::Bold));
        $this->assertTrue($string->elements[1]->attributes->hasAttribute(FormatAttribute::Italic));

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals(' text', $string->elements[2]->string);
        $this->assertCount(1, $string->elements[2]->attributes);
        $this->assertTrue($string->elements[2]->attributes->hasAttribute(FormatAttribute::Bold));
    }

    public function testNormalizedSpacing(): void
    {
        $html = " What happens \t when <strong> we have  \n </strong> lots   of &nbsp;spacing<br> and some text after an explicit linebreak\n\n";
        $string = $this->parseAttributedString($html);
        $this->assertCount(5, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('What happens when ', $string->elements[0]->string);
        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[1]);
        $this->assertEquals('we have ', $string->elements[1]->string);
        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals('lots of  spacing', $string->elements[2]->string);
        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[3]);
        $this->assertEquals("\n", $string->elements[3]->string);
        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[4]);
        $this->assertEquals(" and some text after an explicit linebreak", $string->elements[4]->string);
    }

    public function testLink(): void
    {
        $html = '<a href="https://example.com">Click here</a>';
        $string = $this->parseAttributedString($html);
        $this->assertCount(1, $string->elements);

        $element = $string->elements[0];
        $this->assertInstanceOf(AttributedSubstring::class, $element);
        $this->assertEquals('Click here', $element->string);
        $this->assertCount(1, $element->attributes);
        $this->assertTrue($element->attributes->hasAttribute(LinkAttribute::class));
        $this->assertEquals('https://example.com', $element->attributes->getAttribute(LinkAttribute::class)?->url);
    }

    public function testNestedLinks(): void
    {
        $html = '<a href="https://example.com/outside">Outside <a href="http://www.example.com/inside">inside</a> outside</a>';
        $string = $this->parseAttributedString($html);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('Outside ', $string->elements[0]->string);
        $this->assertCount(1, $string->elements[0]->attributes);
        $this->assertTrue($string->elements[0]->attributes->hasAttribute(LinkAttribute::class));
        $this->assertEquals('https://example.com/outside', $string->elements[0]->attributes->getAttribute(LinkAttribute::class)?->url);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[1]);
        $this->assertEquals('inside', $string->elements[1]->string);
        $this->assertCount(1, $string->elements[1]->attributes);
        $this->assertTrue($string->elements[1]->attributes->hasAttribute(LinkAttribute::class));
        $this->assertEquals('http://www.example.com/inside', $string->elements[1]->attributes->getAttribute(LinkAttribute::class)?->url);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals(' outside', $string->elements[2]->string);
        $this->assertCount(1, $string->elements[2]->attributes);
        $this->assertTrue($string->elements[2]->attributes->hasAttribute(LinkAttribute::class));
        $this->assertEquals('https://example.com/outside', $string->elements[2]->attributes->getAttribute(LinkAttribute::class)?->url);
    }

    public function testImageAttachmentPreservingSpace(): void
    {
        $html = 'This is a text with an image  <img src="https://example.com/image.jpg" alt="Example Image"> embedded in it.';
        $string = $this->parseAttributedString($html, preserveWhitespace: true);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('This is a text with an image  ', $string->elements[0]->string);
        $this->assertCount(0, $string->elements[0]->attributes);

        $this->assertInstanceOf(ImageAttachment::class, $string->elements[1]);
        $this->assertEquals('https://example.com/image.jpg', $string->elements[1]->src);
        $this->assertEquals('Example Image', $string->elements[1]->alt);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals(' embedded in it.', $string->elements[2]->string);
        $this->assertCount(0, $string->elements[2]->attributes);
    }

    public function testImageAttachmentTrimmingWhitespaceAroundAttachments(): void
    {
        $html = 'This is a text with an image  <img src="https://example.com/image.jpg" alt="Example Image"> embedded in it.';
        $string = $this->parseAttributedString($html, trimWhitespaceAroundAttachments: true);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('This is a text with an image', $string->elements[0]->string);
        $this->assertCount(0, $string->elements[0]->attributes);

        $this->assertInstanceOf(ImageAttachment::class, $string->elements[1]);
        $this->assertEquals('https://example.com/image.jpg', $string->elements[1]->src);
        $this->assertEquals('Example Image', $string->elements[1]->alt);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals('embedded in it.', $string->elements[2]->string);
        $this->assertCount(0, $string->elements[2]->attributes);
    }

    public function testImageAttachmentNormalizedWhitespace(): void
    {
        $html = 'This is a text with an image  <img src="https://example.com/image.jpg" alt="Example Image"> embedded in it.';
        $string = $this->parseAttributedString($html);
        $this->assertCount(3, $string->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[0]);
        $this->assertEquals('This is a text with an image ', $string->elements[0]->string);
        $this->assertCount(0, $string->elements[0]->attributes);

        $this->assertInstanceOf(ImageAttachment::class, $string->elements[1]);
        $this->assertEquals('https://example.com/image.jpg', $string->elements[1]->src);
        $this->assertEquals('Example Image', $string->elements[1]->alt);

        $this->assertInstanceOf(AttributedSubstring::class, $string->elements[2]);
        $this->assertEquals(' embedded in it.', $string->elements[2]->string);
        $this->assertCount(0, $string->elements[2]->attributes);
    }
}
