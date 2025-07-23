<?php

namespace MarkupKit\Core\Node\Phrasing;

use DOMElement;
use DOMNode;
use DOMText;

class DefaultPhrasingNodePolicy implements PhrasingNodePolicy
{
    private const array PHRASING_TAG_NAMES = [
        // Text-level semantics
        'a', 'abbr', 'b', 'bdi', 'bdo', 'br', 'cite', 'code', 'data', 'dfn', 'em', 'i', 'kbd',
        'mark', 'q', 'rb', 'rp', 'rt', 'rtc', 'ruby', 's', 'samp', 'small', 'span', 'strong',
        'sub', 'sup', 'time', 'u', 'var', 'wbr',
        // Embedded content allowed in phrasing
        'img', 'iframe', 'object', 'embed', 'picture', 'video', 'audio', 'canvas', 'svg', 'math',
        // Interactive/form elements
        'label', 'select', 'textarea', 'input', 'button', 'datalist', 'output', 'progress',
        'meter', 'option', 'optgroup',
        // Script-related
        'script', 'noscript', 'template', 'slot'
    ];

    public function isPhrasingNode(DOMNode $node): bool
    {
        if ($node instanceof DOMText) {
            return true;
        }

        if (!$node instanceof DOMElement) {
            return false;
        }

        return in_array($node->tagName, self::PHRASING_TAG_NAMES, true);
    }
}
