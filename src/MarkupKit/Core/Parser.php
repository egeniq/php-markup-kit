<?php

namespace MarkupKit\Core;

use DOMElement;
use DOMText;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\AttributedStringBuilder;
use Masterminds\HTML5;

/**
 * @template T
 */
class Parser
{
    /**
     * @param Options<T> $options
     */
    public function __construct(
        public Options $options
    ) {
    }

    /**
     * @return T[]
     */
    public function parseFlowNode(DOMElement $node): array
    {
        return $this->options->nodeParsers->parseFlowNode($node, $this);
    }

    public function parsePhrasingNode(
        DOMElement|DOMText $node,
        AttributedStringBuilder $stringBuilder,
        AttributeContainer $attributes
    ): void {
        $this->options->nodeParsers->parsePhrasingNode($node, $stringBuilder, $attributes, $this);
    }

    private function parseHtml(string $html): ?DOMElement
    {
        $parser = new HTML5(['disable_html_ns' => true]);
        $doc = $parser->parse('<body>' . $html . '</body>');
        return $doc->documentElement;
    }

    /**
     * @return T[]
     */
    public function parse(DOMElement|string $input): array
    {
        if (is_string($input)) {
            $input = $this->parseHtml($input);
            if ($input === null) {
                return [];
            }
        }

        return $this->options->nodeParsers->parseFlowNode($input, $this);
    }
}
