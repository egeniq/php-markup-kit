<?php

namespace MarkupKit\Core\Parsers;

use DOMElement;
use DOMText;

/**
 * @template T of DOMElement|DOMText
 */
class NodeGroup
{
    /**
     * @param array<T> $nodes
     */
    public function __construct(
        private array $nodes = []
    ) {
    }

    /**
     * @param T $node
     */
    public function add(DOMElement|DOMText $node): void
    {
        $this->nodes[] = $node;
    }

    /**
     * @return array<T>
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }
}
