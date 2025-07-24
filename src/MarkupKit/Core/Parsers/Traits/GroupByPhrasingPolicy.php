<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\Parsers\Flow\FlowNodeGroup;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Context;

trait GroupByPhrasingPolicy
{
    /**
     * @param Context<TOutput> $context
     *
     * @return array<PhrasingNodeGroup|FlowNodeGroup>
     *
     * @template TOutput
     */
    protected function groupByPhrasingPolicy(
        DOMElement $node,
        Context $context
    ): array {
        $groups = [];

        $group = null;
        foreach ($node->childNodes as $child) {
            if (!($child instanceof DOMElement) && !($child instanceof DOMText)) {
                continue;
            }

            $isPhrasing = $context->options->phrasingNodePolicy->isPhrasingNode($child);

            if ($isPhrasing && !($group instanceof PhrasingNodeGroup)) {
                $group = new PhrasingNodeGroup();
                $groups[] = $group;
            } elseif (!$isPhrasing && !($group instanceof FlowNodeGroup)) {
                $group = new FlowNodeGroup();
                $groups[] = $group;
            }

            assert($group !== null);

            $group->add($child);
        }

        return $groups;
    }
}
