# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.6.2] - 2026-10-10
### Added
- `Parser::setUnboundedMax()` and `Quantifier` constructor argument to configure the maximum number of repetitions of `*` and `+`
### Changed
- `*` and `+` now repeat at most 100 times by default instead of `PHP_INT_MAX` (previously capped to ~2.8M by `SimpleRandom`)

## [0.6.1] - 2026-10-10
### Added
- Compatibility with PHP 8.5 (no deprecations found in the sources; tests added to the CI matrix)
- Makefile: run any target on PHP 8.1-8.5 via Docker (`PHP=8.x`, `test-php-8.x`, `test-all`, `cs-check`)
### Fixed
- `SplObjectStorage::attach()` deprecation notice on PHP 8.5 in `Generator\Node` (#21)
### Changed
- `docker-compose.yaml`: optional `PHP_REGISTRY` variable to pull PHP images from a registry mirror
- CI: tests now run only on the oldest (8.1) and newest (8.5) supported PHP versions; PHPStan runs on PHP 8.1 only

## [0.6.0] - 2026-03-31
### Added
- Code quality tools: Facile.it coding standard and PHPStan 2 (level 5)
- Composer scripts: `cs-check`, `cs-fix`, `phpstan`, `phpstan-baseline`
- GitHub Actions workflows for code style and static analysis (PHP 8.1-8.4)
- PHPStan baseline for incremental code quality improvements
### Fixed
- Allow SimpleRandom to handle unbounded quantifiers (#13)
### Removed
- Support for PHP 7.4 and 8.0 (minimum required version is now PHP 8.1)

## [0.5.0] - 2024-12-07
### Added
- Compatibility with PHP 8.2, 8.3, 8.4

## [0.4.0] - 2023-11-10
### Added
- Full compatibility with PHP 8.1

## [0.3.1] - 2023-04-21
### Changed
- Allow doctrine/lexer ^2
- Substitute patchwork/utf with symfony/polyfill-mbstring

## [0.3.0] - 2023-04-21
### Changed
- Versioning now adheres to semantic versioning.

## [v0.2.0.0] - 2022-22-18

### Added
- Compatibility with PHP ^8

## [v0.1.0.0 (fork)] - 2022-12-18

See https://github.com/icomefromthenet/ReverseRegex

[Unreleased]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.6.2..HEAD
[0.6.2]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.6.1..0.6.2
[0.6.1]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.6.0..0.6.1
[0.6.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.5.0..0.6.0
[0.5.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.4.0..0.5.0
[0.4.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.3.1..0.4.0
[0.3.1]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.3.0..0.3.1
[0.3.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/v0.2.0.0..0.3.0
[v0.2.0.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/v0.1.0.0..v0.2.0.0
[v0.1.0.0 (fork)]: https://github.com/icomefromthenet/ReverseRegex/releases/tag/v0.1.0.0
