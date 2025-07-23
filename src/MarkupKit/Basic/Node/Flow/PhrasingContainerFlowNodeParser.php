<?php

namespace MarkupKit\Basic\Node\Flow;

use DOMElement;

readonly abstract class PhrasingContainerFlowNodeParser extends DefaultFlowNodeParser
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
