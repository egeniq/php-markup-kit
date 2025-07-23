<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use MarkupKit\Core\Node\Flow\FlowNodeGroup;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Parser;

/**
 * @template T
 */
trait ParseNodeGroup
{
    /**
     * @use ParseFlowNodeGroup<T>
     */
    use ParseFlowNodeGroup;

    /**
     * @use ParsePhrasingNodeGroup<T>
     */
    use ParsePhrasingNodeGroup;

    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    protected function parseNodeGroup(PhrasingNodeGroup|FlowNodeGroup $group, DOMElement $parent, Parser $parser): array
    {
        if ($group instanceof PhrasingNodeGroup) {
            return $this->parsePhrasingNodeGroup($group, $parent, $parser);
        } else {
            return $this->parseFlowNodeGroup($group, $parent, $parser);
        }
    }
}
