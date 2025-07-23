<?php

namespace MarkupKit\Basic\Node\Phrasing;

use DOMElement;
use DOMText;
use MarkupKit\Basic\String\FormatAttribute;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Node\Traits\ParsePhrasingChildNodes;
use MarkupKit\Core\Parser;

readonly class FormatNodeParser implements PhrasingNodeParser
{
    use ParsePhrasingChildNodes;

    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        return $node instanceof DOMElement && in_array($node->tagName, ['strong', 'b', 'em', 'i', 'u'], true);
    }

    public function parsePhrasingNode(
        DOMText|DOMElement $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void {
        assert($node instanceof DOMElement);

        $this->parsePhrasingChildNodes(
            $node,
            $stringBuilder,
            $this->withAttributeForNode($node, $attributes),
            $parser
        );
    }

    protected function withAttributeForNode(
        DOMElement $node,
        AttributeContainer $attributes
    ): AttributeContainer {
        return match ($node->tagName) {
            'strong', 'b' => $attributes->withAttribute(FormatAttribute::Bold),
            'em', 'i' => $attributes->withAttribute(FormatAttribute::Italic),
            'u' => $attributes->withAttribute(FormatAttribute::Underline),
            default => $attributes
        };
    }
}
