<?php

namespace MarkupKit\Core\String\Encoder\Html;

use MarkupKit\Core\String\Attribute;

interface HtmlAttribute extends Attribute
{
    public function getHtmlOpeningTag(): string;
    public function getHtmlClosingTag(): string;
}
