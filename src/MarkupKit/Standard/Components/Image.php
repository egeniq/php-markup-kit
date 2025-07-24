<?php

namespace MarkupKit\Standard\Components;

readonly class Image implements Component
{
    public function __construct(
        public string $src,
        public ?string $alt = null,
        public ?string $title = null,
        public ?string $link = null
    ) {
    }
}
