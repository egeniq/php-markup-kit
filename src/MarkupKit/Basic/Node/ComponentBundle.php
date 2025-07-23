<?php

namespace MarkupKit\Basic\Node;

use MarkupKit\Basic\Components\Component;
use MarkupKit\Core\Node\NodeParserBundle;

/**
 * @extends NodeParserBundle<Component>
 */
readonly class ComponentBundle extends NodeParserBundle
{
    public function __construct()
    {
        parent::__construct([
            // Flow
            new Flow\HeadingNodeParser(),
            new Flow\PreformattedNodeParser(),
            new Flow\QuoteNodeParser(),
            new Flow\DefaultFlowNodeParser(),
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
