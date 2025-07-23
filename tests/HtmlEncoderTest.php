<?php

namespace MarkupKit\Tests;

use MarkupKit\Basic\Node\StringBundle;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\Encoder\Html\HtmlEncoder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class HtmlEncoderTest extends TestCase
{
    /**
     * @var Parser<AttributedString>
     */
    private static Parser $parser;

    private static HtmlEncoder $encoder;

    public static function setUpBeforeClass(): void
    {
        $options = new Options(nodeParsers: [new StringBundle()]);
        self::$parser = new Parser(options: $options);
        self::$encoder = new HtmlEncoder();
    }

    /**
     * @return array<array{string, string}>
     */
    public static function encodingDataProvider(): array
    {
        $data = [
            ['<strong>Bold text</strong>', '<strong>Bold text</strong>'],
            ['<b>Bold text</b>', '<strong>Bold text</strong>'],
            ['<em>Italic text</em>', '<em>Italic text</em>'],
            ['<i>Italic text</i>', '<em>Italic text</em>'],
            ['<strong>Bold <em>and italic</em> text</strong>', '<strong>Bold <em>and italic</em> text</strong>'],
            ['<p>Paragraph with <strong>bold</strong> and <em>italic</em> text.</p>', 'Paragraph with <strong>bold</strong> and <em>italic</em> text.'],
            ['<div><span>Nested span text</span></div>', 'Nested span text'],
            ["Text with extra    spaces and\n such <b> within  tags  </b> but outside   as\n well", 'Text with extra spaces and such <strong>within tags </strong>but outside as well'],
            ['<u>Underlined text</u>', '<u>Underlined text</u>'],
            ['<p><a href="https://example.com">Link</a></p>', '<a href="https://example.com">Link</a>'],
            ['<img src="image.jpg" alt="Image">', '<img src="image.jpg" alt="Image">'],
        ];

        return array_combine(
            array_map(fn ($item) => $item[0], $data),
            $data
        );
    }

    #[DataProvider('encodingDataProvider')]
    public function testEncoding(string $input, string $expectedOutput): void
    {
        $components = self::$parser->parse($input);
        $this->assertCount(1, $components);
        $output = self::$encoder->encode($components[0]);
        $this->assertEquals($expectedOutput, $output);
    }
}
