<?php

namespace MarkupKit\Core\Node\Phrasing;

use DOMNode;

interface PhrasingNodePolicy
{
    public function isPhrasingNode(DOMNode $node): bool;
}
