<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\Node\Flow\FlowNodeGroup;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Parser;

trait GroupByPhrasingPolicy
{
    /**
     * @param Parser<TOutput> $parser
     *
     * @return array<PhrasingNodeGroup|FlowNodeGroup>
     *
     * @template TOutput
     */
    protected function groupByPhrasingPolicy(
        DOMElement $node,
        Parser $parser
    ): array {
        $groups = [];

        $group = null;
        foreach ($node->childNodes as $child) {
            if (!($child instanceof DOMElement) && !($child instanceof DOMText)) {
                continue;
            }

            $isPhrasing = $parser->options->phrasingNodePolicy->isPhrasingNode($child);

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
