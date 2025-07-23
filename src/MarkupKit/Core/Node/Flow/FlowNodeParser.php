<?php

namespace MarkupKit\Core\Node\Flow;

use DOMElement;
use MarkupKit\Core\Parser;

/**
 * @template T
  */
interface FlowNodeParser
{
    public function isFlowNodeSupported(DOMElement $node): bool;

    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node, Parser $parser): array;
}
