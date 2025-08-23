<?php

namespace MarkupKit\Tests;

use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedSubstring;
use MarkupKit\Standard\String\FormatAttribute;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AttributedStringTest extends TestCase
{
    public function testCreation(): void
    {
        $str = AttributedString::fromString('Hello, World!');
        $this->assertCount(1, $str->elements);
        $this->assertInstanceOf(AttributedSubstring::class, $str->elements[0]);
        $this->assertEquals('Hello, World!', $str->elements[0]->string);
    }

    public function testReplaceWithNoMatchesShouldReturnOriginal(): void
    {
        $str = AttributedString::fromString('Hello, World!');
        $replaced = $str->replace('PHP', 'JavaScript');
        $this->assertSame($str, $replaced);
    }

    public function testReplaceWithString(): void
    {
        $str = AttributedString::fromString('Hello, World!');
        $replaced = $str->replace('World', 'PHP');

        $this->assertCount(1, $replaced->elements);
        $this->assertInstanceOf(AttributedSubstring::class, $replaced->elements[0]);
        $this->assertEquals('Hello, PHP!', $replaced->elements[0]->string);
    }

    public function testReplaceWithCallback(): void
    {
        $str = AttributedString::fromString('Hello, World!');
        $replaced = $str->replace(
            'World',
            fn ($match, $attrs) => new AttributedSubstring('PHP', $attrs->withAttribute(FormatAttribute::Bold))
        );

        $this->assertCount(3, $replaced->elements);

        $this->assertInstanceOf(AttributedSubstring::class, $replaced->elements[0]);
        $this->assertEquals('Hello, ', $replaced->elements[0]->string);
        $this->assertInstanceOf(AttributedSubstring::class, $replaced->elements[1]);
        $this->assertTrue($replaced->elements[0]->attributes->isEmpty());
        $this->assertEquals('PHP', $replaced->elements[1]->string);
        $this->assertTrue($replaced->elements[1]->attributes->hasAttribute(FormatAttribute::Bold));
        $this->assertInstanceOf(AttributedSubstring::class, $replaced->elements[2]);
        $this->assertEquals('!', $replaced->elements[2]->string);
        $this->assertTrue($replaced->elements[2]->attributes->isEmpty());
    }

    public function testReplaceMatchesWithNoMatchesShouldReturnOriginal(): void
    {
        $str = AttributedString::fromString('Hello, World!');
        $replaced = $str->replaceMatches('/PHP/', 'JavaScript');
        $this->assertSame($str, $replaced);
    }

    /**
     * @return array<array{string, string, string|(callable(string[] $match): string), string}>
     */
    public static function replaceMatchesProvider(): array
    {
        return [
            ['Hello, World!', '/[,!]/', '', 'Hello World'],
            ['2024-06-15', '/(\d{4})-(\d{2})-(\d{2})/', '$3-$2-$1', '15-06-2024'],
            ['foo_bar_baz', '/_/', ' ', 'foo bar baz'],
            ['a1b2c3', '/[0-9]/', '', 'abc'],
            // @phpstan-ignore-next-line
            ['Hello, World!', '/[A-Z]/', fn ($match) => strtolower($match[0]), 'hello, world!'],
            // @phpstan-ignore-next-line
            ['2024-06-15 - 2024-07-20', '/(\d{4})-(\d{2})-(\d{2})/', fn ($match) => "$match[3]-$match[2]-$match[1]", '15-06-2024 - 20-07-2024'],
            ['foo_bar_baz', '/_/', fn ($match) => ' ', 'foo bar baz'],
            ['a1b2c3', '/[0-9]/', fn ($match) => '', 'abc'],
        ];
    }

    #[DataProvider('replaceMatchesProvider')]
    public function testReplaceMatches(string $input, string $regex, string|callable $replace, string $expectedOutput): void
    {
        $str = AttributedString::fromString($input);
        $replaced = $str->replaceMatches($regex, $replace);

        $this->assertCount(1, $replaced->elements);
        $this->assertInstanceOf(AttributedSubstring::class, $replaced->elements[0]);
        $this->assertEquals($expectedOutput, $replaced->elements[0]->string);
    }
}
