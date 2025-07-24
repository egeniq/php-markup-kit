<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use MarkupKit\Core\Parsers\Flow\FlowNodeGroup;
use MarkupKit\Core\Context;

/**
 * @template T
 */
trait ParseFlowNodeGroup
{
    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    protected function parseFlowNodeGroup(FlowNodeGroup $group, DOMElement $parent, Context $context): array
    {
        $components = [];

        foreach ($group->getNodes() as $node) {
            $components = [
                ...$components,
                ...$context->parseFlowNode($node)
            ];
        }

        return $components;
    }
}
