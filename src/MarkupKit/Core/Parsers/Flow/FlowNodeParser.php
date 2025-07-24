<?php

namespace MarkupKit\Core\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Context;

/**
 * @template T
  */
interface FlowNodeParser
{
    /**
     * @param Context<T> $context
     */
    public function isFlowNodeSupported(DOMElement $node, Context $context): bool;

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node, Context $context): array;
}
