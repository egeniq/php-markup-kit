<?php

namespace MarkupKit\Core\Parsers\Phrasing;

use DOMNode;

interface PhrasingNodePolicy
{
    public function isPhrasingNode(DOMNode $node): bool;
}
