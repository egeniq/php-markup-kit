<?php

namespace MarkupKit\Standard\Parsers;

use MarkupKit\Standard\Parsers\Phrasing\FormatAttributePhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\ImageAttachmentPhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\LineBreakPhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\LinkAttributePhrasingNodeParser;
use MarkupKit\Core\Parsers\Flow\AttributedStringFlowNodeParser;
use MarkupKit\Core\Parsers\NodeParserBundle;
use MarkupKit\Core\Parsers\Phrasing\ChildPhrasingNodeParser;
use MarkupKit\Core\Parsers\Phrasing\TextPhrasingNodeParser;
use MarkupKit\Core\String\AttributedString;

/**
 * @extends NodeParserBundle<AttributedString>
 */
readonly class StringBundle extends NodeParserBundle
{
    public function __construct(
        public bool $preserveWhitespace = false,
        public bool $trimWhitespaceAroundAttachments = false
    ) {
        parent::__construct([
            // Flow
            new AttributedStringFlowNodeParser(
                preserveWhitespace: $preserveWhitespace,
                trimWhitespaceAroundAttachments: $trimWhitespaceAroundAttachments
            ),
            // Phrasing
            new TextPhrasingNodeParser(),
            new LineBreakPhrasingNodeParser(),
            new LinkAttributePhrasingNodeParser(),
            new FormatAttributePhrasingNodeParser(),
            new ImageAttachmentPhrasingNodeParser(),
            new ChildPhrasingNodeParser(),
        ]);
    }
}
