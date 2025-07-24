<?php

namespace MarkupKit\Core\Parsers;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Parsers\Flow\FlowNodeParser;
use MarkupKit\Core\Parsers\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Context;

/**
 * @template T
 *
 * @implements FlowNodeParser<T>
 */
readonly class NodeParserBundle implements FlowNodeParser, PhrasingNodeParser
{
    /**
     * @param array<FlowNodeParser<T>|PhrasingNodeParser> $nodeParsers
     */
    public function __construct(
        public array $nodeParsers
    ) {
    }

    public function isFlowNodeSupported(DOMElement $node, Context $context): bool
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof FlowNodeParser && $nodeParser->isFlowNodeSupported($node, $context)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Context<T> $context
     *
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node, Context $context): array
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof FlowNodeParser && $nodeParser->isFlowNodeSupported($node, $context)) {
                return $nodeParser->parseFlowNode($node, $context);
            }
        }

        return [];
    }

    /**
     * @param Context<mixed> $context
     */
    public function isPhrasingNodeSupported(DOMElement|DOMText $node, Context $context): bool
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof PhrasingNodeParser && $nodeParser->isPhrasingNodeSupported($node, $context)) {
                return true;
            }
        }

        return false;
    }

    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Context $context
    ): void {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof PhrasingNodeParser && $nodeParser->isPhrasingNodeSupported($node, $context)) {
                $nodeParser->parsePhrasingNode($node, $stringBuilder, $attributes, $context);
                return;
            }
        }
    }
}
