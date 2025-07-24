<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;

readonly abstract class PhrasingContainerFlowNodeParser extends ComponentFlowNodeParser
{
    /**
     * @return string[]
     */
    abstract protected function getSupportedTagNames(): array;

    public function isFlowNodeSupported(DOMElement $node): bool
    {
        return in_array($node->nodeName, $this->getSupportedTagNames(), true);
    }
}
