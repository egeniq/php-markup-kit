<?php

namespace MarkupKit\Standard\Parsers;

use MarkupKit\Standard\Components\Component;
use MarkupKit\Standard\Parsers\Flow\ComponentFlowNodeParser;
use MarkupKit\Standard\Parsers\Flow\HeadingFlowNodeParser;
use MarkupKit\Standard\Parsers\Flow\PreformattedFlowNodeParser;
use MarkupKit\Standard\Parsers\Flow\QuoteFlowNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\FormatAttributePhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\ImageAttachmentPhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\LineBreakPhrasingNodeParser;
use MarkupKit\Standard\Parsers\Phrasing\LinkAttributePhrasingNodeParser;
use MarkupKit\Core\Parsers\NodeParserBundle;
use MarkupKit\Core\Parsers\Phrasing\ChildPhrasingNodeParser;
use MarkupKit\Core\Parsers\Phrasing\TextPhrasingNodeParser;

/**
 * @extends NodeParserBundle<Component>
 */
readonly class ComponentBundle extends NodeParserBundle
{
    public function __construct()
    {
        parent::__construct([
            // Flow
            new HeadingFlowNodeParser(),
            new PreformattedFlowNodeParser(),
            new QuoteFlowNodeParser(),
            new ComponentFlowNodeParser(),
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
