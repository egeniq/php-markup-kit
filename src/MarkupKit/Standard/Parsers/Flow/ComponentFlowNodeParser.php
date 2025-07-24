<?php

namespace MarkupKit\Standard\Parsers\Flow;

use DOMElement;
use MarkupKit\Standard\String\ImageAttachment;
use MarkupKit\Standard\String\LinkAttribute;
use MarkupKit\Standard\Components\Component;
use MarkupKit\Standard\Components\Image;
use MarkupKit\Standard\Components\Text;
use MarkupKit\Standard\Components\Text\Style;
use MarkupKit\Core\String\AttributedString;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Parsers\Flow\FlowNodeParser;
use MarkupKit\Core\Parsers\Traits\ParseNodeGroups;
use MarkupKit\Core\Context;

/**
 * @implements FlowNodeParser<Component>
 */
readonly class ComponentFlowNodeParser implements FlowNodeParser
{
    /**
     * @use ParseNodeGroups<Component>
     */
    use ParseNodeGroups;

    public function isFlowNodeSupported(DOMElement $node, Context $context): bool
    {
        return true;
    }

    /**
     * @param Context<Component> $context
     */
    protected function getStyleForNode(DOMElement $node, Context $context): Style
    {
        return Style::Body;
    }

    /**
     * @param Context<Component> $context
     */
    protected function getPreserveWhitespaceForNode(DOMElement $node, Context $context): bool
    {
        return false;
    }

    /**
     * @param Context<Component> $context
     */
    protected function getTrimWhitespaceAroundAttachments(DOMElement $node, Context $context): bool
    {
        return !$this->getPreserveWhitespaceForNode($node, $context);
    }

    /**
     * @param Context<Component> $context
     */
    protected function createStringBuilderForFlowNode(DOMElement $node, Context $context): AttributedStringBuilder
    {
        return new AttributedStringBuilder(
            preserveWhitespace: $this->getPreserveWhitespaceForNode($node, $context),
            trimWhitespaceAroundAttachments: $this->getTrimWhitespaceAroundAttachments($node, $context)
        );
    }

    /**
     * @param Context<Component> $context
     *
     * @return Component[]
     */
    protected function buildPhrasingContent(AttributedString $string, DOMElement $parent, Context $context): array
    {
        $style = $this->getStyleForNode($parent, $context);

        $components = [];
        foreach ($string->splitStringsAndAttachments() as $part) {
            if ($part instanceof AttributedString) {
                $components[] = new Text($part, $style);
            } elseif ($part instanceof ImageAttachment) {
                $link = $part->attributes->getAttribute(LinkAttribute::class)?->url;
                $components[] = new Image($part->src, $part->alt, $part->title, $link);
            }
        }

        return $components;
    }

    public function parseFlowNode(DOMElement $node, Context $context): array
    {
        return $this->parseNodeGroups($node, $context);
    }
}
