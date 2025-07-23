<?php

namespace MarkupKit\Basic\Node\Flow;

use DOMElement;
use MarkupKit\Basic\String\ImageAttachment;
use MarkupKit\Basic\String\LinkAttribute;
use MarkupKit\Basic\Components\Component;
use MarkupKit\Basic\Components\Image;
use MarkupKit\Basic\Components\Text;
use MarkupKit\Basic\Components\Text\Style;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\String\AttributedSubstring;
use MarkupKit\Core\Node\Flow\FlowNodeParser;
use MarkupKit\Core\Node\Traits\ParseNodeGroups;
use MarkupKit\Core\Parser;

/**
 * @implements FlowNodeParser<Component>
 */
readonly class DefaultFlowNodeParser implements FlowNodeParser
{
    /**
     * @use ParseNodeGroups<Component>
     */
    use ParseNodeGroups;

    public function isFlowNodeSupported(DOMElement $node): bool
    {
        return true;
    }

    protected function getStyleForNode(DOMElement $node): Style
    {
        return Style::Body;
    }

    protected function getPreserveWhitespaceForNode(DOMElement $node): bool
    {
        return false;
    }

    /**
     * @param Parser<Component> $parser
     */
    protected function createStringBuilderForFlowNode(DOMElement $node, Parser $parser): AttributedStringBuilder
    {
        return new AttributedStringBuilder(preserveWhitespace: $this->getPreserveWhitespaceForNode($node));
    }

    /**
     * @param Parser<Component> $parser
     *
     * @return Component[]
     */
    protected function buildPhrasingContent(AttributedString $string, DOMElement $parent, Parser $parser): array
    {
        $style = $this->getStyleForNode($parent);

        if ($string->isEmpty()) {
            return [];
        }

        $components = [];
        $elements = [];
        foreach ($string->elements as $element) {
            if ($element instanceof AttributedSubstring) {
                $elements[] = $element;
            } elseif ($element instanceof ImageAttachment) {
                if (count($elements) > 0) {
                    $string = new AttributedString($elements);
                    $components[] = new Text($string, $style);
                    $elements = [];
                }

                $link = $element->attributes->getAttribute(LinkAttribute::class)?->url;
                $components[] = new Image($element->src, $element->alt, $element->title, $link);
            }
        }

        if (count($elements) > 0) {
            $string = new AttributedString($elements);
            $components[] = new Text($string, $style);
        }

        return $components;
    }

    public function parseFlowNode(DOMElement $node, Parser $parser): array
    {
        return $this->parseNodeGroups($node, $parser);
    }
}
