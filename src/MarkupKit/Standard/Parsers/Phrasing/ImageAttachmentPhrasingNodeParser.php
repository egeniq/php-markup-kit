<?php

namespace MarkupKit\Standard\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Standard\String\ImageAttachment;
use MarkupKit\Core\Parsers\Phrasing\AbstractAttachmentPhrasingNodeParser;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributeContainer;

readonly class ImageAttachmentPhrasingNodeParser extends AbstractAttachmentPhrasingNodeParser
{
    /**
 * @param Context<mixed> $context
 */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool
    {
        return $node instanceof DOMElement && $node->tagName === 'img';
    }

    protected function attachmentForNode(
        DOMElement $node,
        AttributeContainer $attributes,
        Context $context
    ): ImageAttachment {
        $src = $node->getAttribute('src');
        $alt = $node->getAttribute('alt') ?: null;
        $title = $node->getAttribute('title') ?: null;
        return new ImageAttachment($src, $alt, $title, $attributes);
    }
}
