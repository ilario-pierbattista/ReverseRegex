# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.0.0] - 2026-06-09

### Added
- Added `Trust\ReverseRegex` as the sole public API for generating strings from supported regex patterns.
- Added focused tests for secure random generation, regex conformance, output limits, and public exception types.
- Added PHP 8.5 Docker Compose and Makefile commands for local development.
- Added dependency auditing to CI.

### Changed
- Renamed the Composer package to `trust-psp/reverse-regex`.
- Raised the minimum supported PHP version from 8.1 to 8.5.
- Marked the legacy `ReverseRegex` and `PHPStats` APIs as internal implementation details.
- Changed generation to use PHP's cryptographically secure `random_int()` source.
- Changed invalid or unsupported patterns to throw `InvalidArgumentException`.
- Updated Composer scripts to `lint`, `lint:fix`, `stan`, and `stan:baseline`.
- Updated PHPUnit, PHPStan, code-style configuration, documentation, and development tooling for the maintained `Trust` API.
- Updated GitHub Actions workflows to run on PHP 8.5 and pinned third-party actions to immutable commit SHAs.

### Security
- Limited generated values to a maximum of 40 characters.
- Rejects patterns whose maximum possible output exceeds 40 characters, including unbounded `*` and `+` quantifiers.
- Added a post-generation length check as a secondary safeguard.

### Fixed
- Replaced deprecated `SplObjectStorage::attach()` and `detach()` calls for PHP 8.5 compatibility.

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

[Unreleased]: https://github.com/trust-psp/reverse-regex/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/trust-psp/reverse-regex/releases/tag/v1.0.0
[0.6.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.5.0..0.6.0
[0.5.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.4.0..0.5.0
[0.4.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.3.1..0.4.0
[0.3.1]: https://github.com/ilario-pierbattista/ReverseRegex/compare/0.3.0..0.3.1
[0.3.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/v0.2.0.0..0.3.0
[v0.2.0.0]: https://github.com/ilario-pierbattista/ReverseRegex/compare/v0.1.0.0..v0.2.0.0
[v0.1.0.0 (fork)]: https://github.com/icomefromthenet/ReverseRegex/releases/tag/v0.1.0.0
