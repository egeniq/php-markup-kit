<?php

namespace MarkupKit\Tests;

use MarkupKit\Standard\Parsers\StringBundle;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\Encoder\Markdown\MarkdownEncoder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class MarkdownEncoderTest extends TestCase
{
    private static Parser $parser;

    /**
     * @var Options<AttributedString>
     */
    private static Options $options;

    private static MarkdownEncoder $encoder;

    public static function setUpBeforeClass(): void
    {
        self::$parser = new Parser();
        self::$options = new Options(nodeParsers: [new StringBundle()]);
        self::$encoder = new MarkdownEncoder();
    }

    /**
     * @return array<array{string, string}>
     */
    public static function encodingDataProvider(): array
    {
        $data = [
            ['<strong>Bold text</strong>', '**Bold text**'],
            ['<b>Bold text</b>', '**Bold text**'],
            ['<em>Italic text</em>', '*Italic text*'],
            ['<i>Italic text</i>', '*Italic text*'],
            ['<strong>Bold <em>and italic</em> text</strong>', '**Bold *and italic* text**'],
            ['<p>Paragraph with <strong>bold</strong> and <em>italic</em> text.</p>', 'Paragraph with **bold** and *italic* text.'],
            ['<div><span>Nested span text</span></div>', 'Nested span text'],
            ["Text with extra    spaces and\n such <b> within  tags  </b> but outside   as\n well", 'Text with extra spaces and such **within tags **but outside as well'],
            ['<u>Underlined text</u>', '__Underlined text__'],
            ['<p><a href="https://example.com">Link</a></p>', '[Link](https://example.com)'],
            ['<img src="image.jpg" alt="Image">', '![Image](image.jpg)'],
            ['<img src="image.jpg" alt="Image" title="Title">', '![Image](image.jpg "Title")'],
            ['<img src="image.jpg" alt="">', '![image](image.jpg)'],
            ['<img src="image.jpg">', '![image](image.jpg)'],
        ];

        return array_combine(
            array_map(fn ($item) => $item[0], $data),
            $data
        );
    }

    #[DataProvider('encodingDataProvider')]
    public function testEncoding(string $input, string $expectedOutput): void
    {
        $components = self::$parser->parse($input, self::$options);
        $this->assertCount(1, $components);
        $output = self::$encoder->encode($components[0]);
        $this->assertEquals($expectedOutput, $output);
    }
}
