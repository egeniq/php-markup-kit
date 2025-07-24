<?php

namespace MarkupKit\Standard\Components;

use MarkupKit\Standard\Components\ItemList\Item;

readonly class UnorderedList implements Component
{
    /**
     * @param array<Item> $items
     */
    public function __construct(
        public array $items
    ) {
    }
}
