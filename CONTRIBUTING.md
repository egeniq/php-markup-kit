# Contributing to PHP MarkupKit

Thank you for your interest in contributing to PHP MarkupKit! Your help is greatly appreciated. 
Please follow these guidelines to help us maintain a high-quality project.

## How to Contribute
- **Fork the repository** and create your branch from `main`.
- **Write clear, concise commit messages**.
- **Add tests** for new features or bug fixes.
- **Ensure all tests pass** before submitting a pull request.
- **Follow the coding standards** (see `phpcs.xml`).

## Reporting Issues
- Search for existing issues before submitting a new one.
- Provide a clear and descriptive title and description.
- Include steps to reproduce the issue, if possible.

## Pull Requests
- Describe your changes in detail.
- Reference any related issues.
- Keep pull requests focused and small.

## Code Style
- Follow PSR-12 coding standards.
- Run `phpcs` to check code style.

## Static Analysis
Run PHPStan to perform static analysis:

```bash
vendor/bin/phpstan analyse
```

## Running Tests
Run the test suite with:

```bash
vendor/bin/phpunit
```

## License
By contributing, you agree that your contributions will be licensed under the MIT License.
