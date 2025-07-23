<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use MarkupKit\Core\Node\Flow\FlowNodeGroup;
use MarkupKit\Core\Parser;

/**
 * @template T
 */
trait ParseFlowNodeGroup
{
    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    protected function parseFlowNodeGroup(FlowNodeGroup $group, DOMElement $parent, Parser $parser): array
    {
        $components = [];

        foreach ($group->getNodes() as $node) {
            $components = [
                ...$components,
                ...$parser->parseFlowNode($node)
            ];
        }

        return $components;
    }
}
