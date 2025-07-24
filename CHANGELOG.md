# Changelog

All notable changes to this project will be documented in this file.

## v1.2 - 2025-07-24
- Added ability to strip attributes from attributed strings.
- `Context` is now provided at more places in the parser.
- Added `ItemList` component and parser for parsing `ul` and `ol` elements.

## v1.1 - 2025-07-24
- Simplified the main parser and moved options to the `parse` method.
- Introduced `Context` class to provide access to the options and for storing context-specific values.
- Renamed the `Basic` implementation namespace to `Standard` to better reflect its purpose.
- Moved node parsers into the `Core` namespace that are also usable outside the standard implementation.

## v1.0 - 2025-07-23
Initial release of PHP MarkupKit
