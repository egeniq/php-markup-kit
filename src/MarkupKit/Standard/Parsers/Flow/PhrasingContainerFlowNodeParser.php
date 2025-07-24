<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Context;

readonly abstract class PhrasingContainerFlowNodeParser extends ComponentFlowNodeParser
{
    /**
     * @return string[]
     */
    abstract protected function getSupportedTagNames(): array;

    public function isFlowNodeSupported(DOMElement $node, Context $context): bool
    {
        return in_array($node->nodeName, $this->getSupportedTagNames(), true);
    }
}
