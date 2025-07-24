<?php

namespace MarkupKit\Core\Parsers\Flow;

use DOMElement;
use DOMText;
use MarkupKit\Core\Parsers\Traits\ParseNodeGroups;
use MarkupKit\Core\Context;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedStringBuilder;

/**
 * @implements FlowNodeParser<AttributedString>
 */
readonly class AttributedStringFlowNodeParser implements FlowNodeParser
{
    /**
     * @use ParseNodeGroups<AttributedString>
     */
    use ParseNodeGroups;

    public function __construct(
        public bool $preserveWhitespace = false,
        public bool $trimWhitespaceAroundAttachments = false
    ) {
    }

    public function isFlowNodeSupported(DOMElement $node, Context $context): bool
    {
        return true;
    }

    /**
     * @param Context<AttributedString> $context
     */
    protected function createStringBuilderForFlowNode(
        DOMText|DOMElement $node,
        Context $context
    ): AttributedStringBuilder {
        return new AttributedStringBuilder(
            preserveWhitespace: $this->preserveWhitespace,
            trimWhitespaceAroundAttachments: $this->trimWhitespaceAroundAttachments
        );
    }

    protected function buildPhrasingContent(AttributedString $string, DOMElement $parent, Context $context): array
    {
        return [$string];
    }

    public function parseFlowNode(DOMElement $node, Context $context): array
    {
        return $this->parseNodeGroups($node, $context);
    }
}
