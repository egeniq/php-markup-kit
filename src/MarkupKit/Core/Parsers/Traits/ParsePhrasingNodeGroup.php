<?php

namespace MarkupKit\Core\Parsers\Traits;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeGroup;
use MarkupKit\Core\Context;

/**
 * @template T
 */
trait ParsePhrasingNodeGroup
{
    /**
     * @param Context<T> $context
     */
    protected function createStringBuilderForFlowNode(
        DOMElement|DOMText $node,
        Context $context
    ): AttributedStringBuilder {
        return new AttributedStringBuilder();
    }

    /**
     * @param Context<T> $context
     */
    protected function createAttributeContainerForFlowNode(
        DOMElement|DOMText $node,
        Context $context
    ): AttributeContainer {
        return new AttributeContainer();
    }

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    abstract protected function buildPhrasingContent(
        AttributedString $string,
        DOMElement $parent,
        Context $context
    ): array;

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    protected function parsePhrasingNodeGroup(PhrasingNodeGroup $group, DOMElement $parent, Context $context): array
    {
        $stringBuilder = $this->createStringBuilderForFlowNode($parent, $context);
        $attributes = $this->createAttributeContainerForFlowNode($parent, $context);

        foreach ($group->getNodes() as $node) {
            $context->parsePhrasingNode($node, $stringBuilder, $attributes);
        }

        return $this->buildPhrasingContent($stringBuilder->build(), $parent, $context);
    }
}
