<?php

namespace MarkupKit\Core;

use DOMElement;
use Masterminds\HTML5;

class Parser
{
    private function parseHtml(string $html): ?DOMElement
    {
        $parser = new HTML5(['disable_html_ns' => true]);
        $doc = $parser->parse('<body>' . $html . '</body>');
        return $doc->documentElement;
    }

    /**
     * @param Context<T>|Options<T> $contextOrOptions
     *
     * @return T[]
     *
     * @template T
     */
    public function parse(DOMElement|string $input, Context|Options $contextOrOptions): array
    {
        $context = $contextOrOptions instanceof Context ? $contextOrOptions : new Context($contextOrOptions);

        if (is_string($input)) {
            $input = $this->parseHtml($input);
            if ($input === null) {
                return [];
            }
        }

        return $context->parseFlowNode($input);
    }
}
