<?php

namespace MarkupKit\Core;

use MarkupKit\Core\Parsers\Flow\FlowNodeParser;
use MarkupKit\Core\Parsers\NodeParserBundle;
use MarkupKit\Core\Parsers\Phrasing\DefaultPhrasingNodePolicy;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodePolicy;

/**
 * @template T
 */
readonly class Options
{
    /**
     * @var NodeParserBundle<T>
     */
    public NodeParserBundle $nodeParsers;

    /**
     * @param array<FlowNodeParser<T>|PhrasingNodeParser>|NodeParserBundle<T> $nodeParsers
     */
    public function __construct(
        array|NodeParserBundle $nodeParsers,
        public PhrasingNodePolicy $phrasingNodePolicy = new DefaultPhrasingNodePolicy(),
    ) {
        $this->nodeParsers = $nodeParsers instanceof NodeParserBundle ? $nodeParsers : new NodeParserBundle($nodeParsers);
    }
}
