<?php

namespace MarkupKit\Core\Node;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use MarkupKit\Core\Node\Flow\FlowNodeParser;
use MarkupKit\Core\Node\Phrasing\PhrasingNodeParser;
use MarkupKit\Core\Parser;

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

    public function isFlowNodeSupported(DOMElement $node): bool
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof FlowNodeParser && $nodeParser->isFlowNodeSupported($node)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Parser<T> $parser
     *
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node, Parser $parser): array
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof FlowNodeParser && $nodeParser->isFlowNodeSupported($node)) {
                return $nodeParser->parseFlowNode($node, $parser);
            }
        }

        return [];
    }

    public function isPhrasingNodeSupported(DOMElement|DOMText $node): bool
    {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof PhrasingNodeParser && $nodeParser->isPhrasingNodeSupported($node)) {
                return true;
            }
        }

        return false;
    }

    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes,
        Parser $parser
    ): void {
        foreach ($this->nodeParsers as $nodeParser) {
            if ($nodeParser instanceof PhrasingNodeParser && $nodeParser->isPhrasingNodeSupported($node)) {
                $nodeParser->parsePhrasingNode($node, $stringBuilder, $attributes, $parser);
                return;
            }
        }
    }
}
