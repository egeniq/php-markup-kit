<?php

namespace MarkupKit\Basic\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Basic\String\ImageAttachment;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Parser;

readonly class ImageNodeParser implements PhrasingNodeParser
{
    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMElement && $node->tagName === 'img';
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void {
        assert($node instanceof DOMElement);
        $src = $node->getAttribute('src');
        $alt = $node->getAttribute('alt') ?: null;
        $title = $node->getAttribute('title') ?: null;
        $attachment = new ImageAttachment($src, $alt, $title, $attributes);
        $stringBuilder->appendAttachment($attachment);
    }
}
