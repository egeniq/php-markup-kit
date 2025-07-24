<?php

namespace MarkupKit\Standard\Components;

readonly class ItemList implements Component
{
    /**
     * @param array<ItemList\Item> $items
     */
    public function __construct(
        public ItemList\Type $type,
        public array $items,
    ) {
    }
}
