<?php

namespace MarkupKit\Basic\Node\Flow;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\Node\Flow\FlowNodeParser;
use MarkupKit\Core\Node\Traits\ParseNodeGroups;
use MarkupKit\Core\Parser;
use MarkupKit\Core\String\AttributedStringBuilder;

/**
 * @implements FlowNodeParser<AttributedString>
 */
readonly class AttributedStringNodeParser implements FlowNodeParser
{
    /**
     * @use ParseNodeGroups<AttributedString>
     */
    use ParseNodeGroups;

    public function isFlowNodeSupported(DOMElement $node): bool
    {
        return true;
    }

    /**
     * @param Parser<AttributedString> $parser
     */
    protected function createStringBuilderForFlowNode(
        DOMText|DOMElement $node,
        Parser $parser
    ): AttributedStringBuilder {
        return new AttributedStringBuilder(trimWhitespaceAroundAttachments: false);
    }

    protected function buildPhrasingContent(AttributedString $string, DOMElement $parent, Parser $parser): array
    {
        return [$string];
    }

    public function parseFlowNode(DOMElement $node, Parser $parser): array
    {
        return $this->parseNodeGroups($node, $parser);
    }
}
