<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Core\Parsers\Flow\FlowNodeParser;
use MarkupKit\Core\Context;
use MarkupKit\Standard\Components\Component;
use MarkupKit\Standard\Components\ItemList;

/**
 * @implements FlowNodeParser<Component>
 */
readonly class ItemListFlowNodeParser implements FlowNodeParser
{
    public function isFlowNodeSupported(DOMElement $node, Context $context): bool
    {
        return $node->nodeName === 'ol' || $node->nodeName === 'ul';
    }

    public function parseFlowNode(DOMElement $node, Context $context): array
    {
        $items = [];

        foreach ($node->childNodes as $child) {
            if ($child instanceof DOMElement && $child->nodeName === 'li') {
                $items[] = new ItemList\Item(
                    content: $context->parseFlowNode($child),
                );
            }
        }

        $type = match ($node->tagName) {
            'ol' => ItemList\Type::Ordered,
            default => ItemList\Type::Unordered
        };

        return [new ItemList(type: $type, items: $items)];
    }
}
