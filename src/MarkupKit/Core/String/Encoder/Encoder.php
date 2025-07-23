<?php

namespace MarkupKit\Core\String\Encoder;

use MarkupKit\Core\String\AttributedString;

interface Encoder
{
    public function encode(AttributedString $string): string;
}
