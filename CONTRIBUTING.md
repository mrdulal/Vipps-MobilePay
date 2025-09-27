# Contributing to Laravel MobilePay Vipps Package

Thank you for considering contributing to the Laravel MobilePay Vipps package! This document outlines the process for contributing to this project.

## Development Setup

1. Clone the repository:
```bash
git clone https://github.com/mrdulal/laravel-vipps.git
cd laravel-vipps
```

2. Install dependencies:
```bash
composer install
```

3. Run tests:
```bash
composer test
```

## Coding Standards

This project follows PSR-12 coding standards. Please ensure your code adheres to these standards before submitting a pull request.

- Use PHP 8.1+ features where appropriate
- Follow Laravel package development best practices
- Write comprehensive tests for new features
- Document all public methods and classes

## Testing

All contributions should include appropriate tests. We use PHPUnit for testing with Orchestra Testbench for Laravel integration testing.

### Running Tests

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage
```

### Writing Tests

- Unit tests should go in `tests/Unit/`
- Feature tests should go in `tests/Feature/`
- All tests should extend the base `TestCase` class

## Pull Request Process

1. Fork the repository
2. Create a feature branch from `main`
3. Make your changes
4. Add/update tests as necessary
5. Ensure all tests pass
6. Update documentation if needed
7. Submit a pull request

### Pull Request Guidelines

- Provide a clear description of the changes
- Include relevant issue numbers
- Ensure CI passes
- Update CHANGELOG.md if applicable

## Feature Requests

Feature requests are welcome! Please open an issue to discuss the feature before implementing.

## Bug Reports

When reporting bugs, please include:

- PHP version
- Laravel version
- Package version
- Steps to reproduce
- Expected behavior
- Actual behavior
- Any error messages

## API Compatibility

This package follows semantic versioning. Breaking changes will only be introduced in major releases.

## Development Guidelines

### Adding New Services

When adding new Vipps API services:

1. Create a service class in `src/Services/`
2. Add validation methods
3. Add comprehensive error handling
4. Update the `VippsManager` class
5. Add corresponding tests
6. Update documentation

### Event Handling

When adding new events:

1. Create event class in `src/Events/`
2. Fire events from appropriate service methods
3. Update webhook handling if needed
4. Add tests for event firing

### Configuration

When adding new configuration options:

1. Add to `config/vipps.php`
2. Provide sensible defaults
3. Document in README.md
4. Add validation if needed

## Code Review

All contributions will be reviewed by maintainers. Please be patient during the review process and be open to feedback.

## License

By contributing to this project, you agree that your contributions will be licensed under the MIT License.