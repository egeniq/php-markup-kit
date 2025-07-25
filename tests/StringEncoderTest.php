<?php

namespace MarkupKit\Tests;

use MarkupKit\Standard\Parsers\StringBundle;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StringEncoderTest extends TestCase
{
    private static Parser $parser;

    /**
     * @var Options<AttributedString>
     */
    private static Options $options;

    public static function setUpBeforeClass(): void
    {
        self::$parser = new Parser();
        self::$options = new Options(nodeParsers: [new StringBundle()]);
    }

    /**
     * @return array<array{string, string}>
     */
    public static function encodingDataProvider(): array
    {
        $data = [
            ['<strong>Bold text</strong>', 'Bold text'],
            ['<em>Italic text</em>', 'Italic text'],
            ['<strong>Bold <em>and italic</em> text</strong>', 'Bold and italic text'],
            ['<p>Paragraph with <strong>bold</strong> and <em>italic</em> text.</p>', 'Paragraph with bold and italic text.'],
            ['<div><span>Nested span text</span></div>', 'Nested span text'],
            ["Text with extra    spaces and\n such <b> within  tags  </b> but outside   as\n well", 'Text with extra spaces and such within tags but outside as well'],
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
        $output = (string)$components[0];
        $this->assertEquals($expectedOutput, $output);
    }
}
