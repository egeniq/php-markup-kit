<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\Attachment;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Context;

abstract readonly class AbstractAttachmentPhrasingNodeParser implements PhrasingNodeParser
{
    /**
     * @param Context<mixed> $context
     */
    abstract protected function attachmentForNode(
        DOMElement $node,
        AttributeContainer $attributes,
        Context $context
    ): ?Attachment;

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        assert($node instanceof DOMElement);
        $attachment = $this->attachmentForNode($node, $attributes, $context);
        if ($attachment !== null) {
            $stringBuilder->appendAttachment($attachment);
        }
    }
}
