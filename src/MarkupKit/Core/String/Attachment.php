<?php

namespace MarkupKit\Core\String;

readonly abstract class Attachment implements AttributedElement
{
    public function __construct(
        public AttributeContainer $attributes = new AttributeContainer()
    ) {
    }
}
