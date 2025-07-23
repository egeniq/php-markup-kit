<?php

namespace MarkupKit\Core\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Parser;

interface PhrasingNodeParser
{
    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool;

    /**
     * @param Parser<mixed> $parser
     */
    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void;
}
