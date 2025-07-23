<?php

namespace MarkupKit\Core\String\Encoder\Html;

use MarkupKit\Core\String\AttributedElement;

interface HtmlElement extends AttributedElement
{
    public function getHtml(): string;
}
