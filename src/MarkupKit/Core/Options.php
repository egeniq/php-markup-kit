<?php

namespace MarkupKit\Core;

use MarkupKit\Core\Node\Flow\FlowNodeParser;
use MarkupKit\Core\Node\NodeParserBundle;
use MarkupKit\Core\Node\Phrasing\DefaultPhrasingNodePolicy;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Node\Phrasing\PhrasingNodePolicy;

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
