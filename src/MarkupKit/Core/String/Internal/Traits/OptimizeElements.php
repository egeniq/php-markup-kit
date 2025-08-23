<?php

namespace MarkupKit\Core\String\Internal\Traits;

use MarkupKit\Core\String\Attachment;
use MarkupKit\Core\String\AttributedSubstring;

/**
 * @internal
 */
trait OptimizeElements
{
    /**
     * @param (AttributedSubstring|Attachment)[] $elements
     * @return (AttributedSubstring|Attachment)[]
     */
    private function optimizeElements(array $elements): array
    {
        if (count($elements) === 0) {
            return $elements;
        }

        return array_reduce(
            array_slice($elements, 1),
            function (array $carry, AttributedSubstring|Attachment $item): array {
                $last = $carry[count($carry) - 1];
                if (
                    $last instanceof AttributedSubstring &&
                    $item instanceof AttributedSubstring &&
                    $last->attributes->equals($item->attributes)
                ) {
                    $carry[count($carry) - 1] = new AttributedSubstring($last->string . $item->string, $last->attributes);
                } else {
                    $carry[] = $item;
                }

                /** @var (AttributedSubstring|Attachment)[] $carry */
                return $carry;
            },
            [$elements[0]]
        );
    }
}
