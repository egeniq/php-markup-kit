<?php

namespace MarkupKit\Basic\Node;

use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\Node\NodeParserBundle;

/**
 * @extends NodeParserBundle<AttributedString>
 */
readonly class StringBundle extends NodeParserBundle
{
    public function __construct()
    {
        parent::__construct([
            // Flow
            new Flow\AttributedStringNodeParser(),
            // Phrasing
            new Phrasing\TextNodeParser(),
            new Phrasing\LineBreakNodeParser(),
            new Phrasing\LinkNodeParser(),
            new Phrasing\FormatNodeParser(),
            new Phrasing\ImageNodeParser(),
            new Phrasing\DefaultPhrasingNodeParser(),
        ]);
    }
}
