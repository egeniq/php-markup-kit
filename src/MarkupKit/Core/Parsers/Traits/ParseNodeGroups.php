<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use MarkupKit\Core\Context;

/**
 * @template T
 */
trait ParseNodeGroups
{
    use GroupByPhrasingPolicy;

    /**
     * @use ParseNodeGroup<T>
     */
    use ParseNodeGroup;

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    protected function parseNodeGroups(DOMElement $node, Context $context): array
    {
        $groups = $this->groupByPhrasingPolicy($node, $context);

        $components = [];
        foreach ($groups as $group) {
            $components = [
                ...$components,
                ...$this->parseNodeGroup($group, $node, $context),
            ];
        }

        return $components;
    }
}
