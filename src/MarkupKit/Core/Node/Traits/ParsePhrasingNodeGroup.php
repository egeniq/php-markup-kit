<?php

namespace MarkupKit\Core\Node\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Parser;

/**
 * @template T
 */
trait ParsePhrasingNodeGroup
{
    /**
     * @param Parser<T> $parser
     */
    protected function createStringBuilderForFlowNode(
        DOMElement|DOMText $node,
        Parser $parser
    ): AttributedStringBuilder {
        return new AttributedStringBuilder();
    }

    /**
     * @param Parser<T> $parser
     */
    protected function createAttributeContainerForFlowNode(
        DOMElement|DOMText $node,
        Parser $parser
    ): AttributeContainer {
        return new AttributeContainer();
    }

    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    abstract protected function buildPhrasingContent(
        AttributedString $string,
        DOMElement $parent,
        Parser $parser
    ): array;

    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    protected function parsePhrasingNodeGroup(PhrasingNodeGroup $group, DOMElement $parent, Parser $parser): array
    {
        $stringBuilder = $this->createStringBuilderForFlowNode($parent, $parser);
        $attributes = $this->createAttributeContainerForFlowNode($parent, $parser);

        foreach ($group->getNodes() as $node) {
            $parser->parsePhrasingNode($node, $stringBuilder, $attributes);
        }

        return $this->buildPhrasingContent($stringBuilder->build(), $parent, $parser);
    }
}
