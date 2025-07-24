# PHP MarkupKit

PHP MarkupKit is a library for parsing HTML into a flexible (component) structure.
and manipulating markup (such as HTML) in PHP. It provides a flexible API for working with markup structures, components, and attributed strings.

## Features
- Parse HTML to flexible component structures
- Represent phrasing markup as attributed strings
- Encode attributed strings to text, HTML and Markdown
- Extensible architecture for custom components

## Installation

Install via Composer:

```bash
composer require egeniq/php-markup-kit
```

## Usage Example

If you want to simply parse a string with HTML tags for simple formatting, linking and images you
can use the following code:

```php
use MarkupKit\Standard\Parsers\StringBundle;
use MarkupKit\Standard\String\FormatAttribute;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\AttributedSubstring;

$parser = new Parser();
$options = new Options(new StringBundle());
$components = $parser->parse("<strong>Hello World!</strong>", $options);

assert(count($components) === 1);
$string = $components[0];

assert(count($string->elements) === 1);
assert($string->elements[0] instanceof AttributedSubstring);
assert($string->elements[0]->string === 'Hello World!');
assert($string->elements[0]->attributes->hasAttribute(FormatAttribute::Bold));
```

If you want to build a more complex component structure, you can use the provided basic
implementation as a starting point:

```php
use MarkupKit\Standard\Parsers\ComponentBundle;
use MarkupKit\Standard\Components;
use MarkupKit\Standard\String\FormatAttribute;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\AttributedSubstring;

$parser = new Parser();
$options = new Options(new ComponentBundle());
$components = $parser->parse('<strong>Hello World!</strong> <img src="https://picsum.photos/id/237/200/300.jpg" alt="Image">', $options);

assert(count($components) === 2);

assert($components[0] instanceof Components\Text);
$string = $components[0]->string;
assert(count($string->elements) === 1);
assert($string->elements[0] instanceof AttributedSubstring);
assert($string->elements[0]->string === 'Hello World!');
assert($string->elements[0]->attributes->hasAttribute(FormatAttribute::Bold));

assert($components[1] instanceof Components\Image);
assert($components[1]->src === 'https://picsum.photos/id/237/200/300.jpg');
assert($components[1]->alt === 'Image');
```

Encoding attributed strings back to HTML or Markdown is also straightforward:

```php
use MarkupKit\Standard\Parsers\StringBundle;
use MarkupKit\Core\Options;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\Encoder\Html\HtmlEncoder;
use MarkupKit\Core\String\Encoder\Markdown\MarkdownEncoder;

$parser = new Parser();
$options = new Options(new StringBundle());
$components = $parser->parse("<strong>Hello World!</strong>", $options);
$string = $components[0];

$htmlEncoder = new HtmlEncoder();
$html = $htmlEncoder->encode($string);
echo $html ."\n"; // <strong>Hello World!</strong>

$markdownEncoder = new MarkdownEncoder();
$markdown = $markdownEncoder->encode($string);
echo $markdown . "\n"; // **Hello World!**
```

More usage examples can be found in the [tests](tests/) directory.

## Directory Structure
- `src/MarkupKit/Core/` - HTML parser and other core functionality
- `src/MarkupKit/Standard/` - Standard implementation for parsing to components or attributed strings
- `tests/` - Unit tests

## Contributing
Pull requests and issues are welcome. Please see the [CONTRIBUTING](CONTRIBUTING.md) guidelines.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
