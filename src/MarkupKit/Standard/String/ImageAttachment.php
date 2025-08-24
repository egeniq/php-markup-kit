<?php

namespace MarkupKit\Standard\String;

use MarkupKit\Core\String\Attachment;
use MarkupKit\Core\String\Attribute;
use MarkupKit\Core\String\AttributeContainer;
use MarkupKit\Core\String\Encoder\Html\HtmlElement;
use MarkupKit\Core\String\Encoder\Markdown\MarkdownElement;

final readonly class ImageAttachment extends Attachment implements HtmlElement, MarkdownElement
{
    /**
     * @param AttributeContainer|array<int, Attribute> $attributes
     */
    public function __construct(
        public string $src,
        public ?string $alt,
        public ?string $title,
        AttributeContainer|array $attributes
    ) {
        parent::__construct($attributes);
    }

    public function getHtml(): string
    {
        $alt = $this->alt ? ' alt="' . htmlspecialchars($this->alt, ENT_QUOTES) . '"' : '';
        $title = $this->title ? ' title="' . htmlspecialchars($this->title, ENT_QUOTES) . '"' : '';

        return sprintf(
            '<img src="%s"%s%s>',
            htmlspecialchars($this->src, ENT_QUOTES),
            $alt,
            $title
        );
    }

    public function getMarkdown(): string
    {
        $alt = $this->alt ?? 'image';
        $title = $this->title ? ' "' . $this->title . '"' : '';

        return sprintf(
            '![%s](%s%s)',
            $alt,
            $this->src,
            $title
        );
    }

    public function replacingAttributes(AttributeContainer $attributes): static
    {
        return new  self(
            $this->src,
            $this->alt,
            $this->title,
            $attributes
        );
    }
}
