<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use MarkupKit\Core\Parser;

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
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    protected function parseNodeGroups(DOMElement $node, Parser $parser): array
    {
        $groups = $this->groupByPhrasingPolicy($node, $parser);

        $components = [];
        foreach ($groups as $group) {
            $components = [
                ...$components,
                ...$this->parseNodeGroup($group, $node, $parser),
            ];
        }

        return $components;
    }
}
