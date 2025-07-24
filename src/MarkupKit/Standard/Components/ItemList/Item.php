<?php

namespace MarkupKit\Standard\Components\ItemList;

use MarkupKit\Standard\Components\Component;

readonly class Item
{
    /**
     * @param array<Component> $content
     */
    public function __construct(
        public array $content,
    ) {
    }
}
