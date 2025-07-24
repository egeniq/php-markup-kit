<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use MarkupKit\Core\Parsers\Flow\FlowNodeGroup;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Context;

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
     * @param Context<T> $context
     *
     * @return T[]
     */
    protected function parseNodeGroup(PhrasingNodeGroup|FlowNodeGroup $group, DOMElement $parent, Context $context): array
    {
        if ($group instanceof PhrasingNodeGroup) {
            return $this->parsePhrasingNodeGroup($group, $parent, $context);
        } else {
            return $this->parseFlowNodeGroup($group, $parent, $context);
        }
    }
}
