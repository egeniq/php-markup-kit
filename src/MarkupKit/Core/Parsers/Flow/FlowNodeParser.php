<?php

namespace MarkupKit\Core\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Context;

/**
 * @template T
  */
interface FlowNodeParser
{
    public function isFlowNodeSupported(DOMElement $node): bool;

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node, Context $context): array;
}
