# AGENTS.md

PHP library (`ilario-pierbattista/reverse-regex`) that generates random strings from a regular expression. Fork of `icomefromthenet/reverse-regex`. See `README.md` for usage and supported syntax.

## Layout

- `src/ReverseRegex/` – library code (PSR-0 autoload: `ReverseRegex\`, `PHPStats\`).
  - `Lexer`, `Parser` (+ `Parser/*` strategies) turn a regex into a tree of `Generator/Scope` nodes.
  - `Random/*` – random number generators.
- `src/ReverseRegex/Test/` – PHPUnit tests (live next to the sources, not in `tests/`).
- `examples/` – runnable usage examples.
- `CHANGELOG.md` – Keep a Changelog format; add entries under `[Unreleased]`.

## Requirements

- PHP `^8.1` (CI tests 8.1 and 8.5; the versions in between are expected to behave the same). Do not use syntax or APIs newer than 8.1.
- Docker is optional: the `Makefile` wraps commands in `docker compose` (PHP 8.1 image).

## Commands

Run directly with a local PHP, or via `make <target>` (Docker):

| Task | Command |
| --- | --- |
| Install | `composer install` (`make setup`) |
| Tests | `vendor/bin/phpunit` (`make test`) |
| Code style check | `composer cs-check` |
| Code style fix | `composer cs-fix` (`make cs-fix`) |
| Static analysis | `composer phpstan` (`make phpstan`) |
| Regenerate PHPStan baseline | `composer phpstan-baseline` (`make phpstan-update-baseline`) |

## Rules

- Before finishing, tests, `cs-check` and `phpstan` must pass (all enforced by CI in `.github/workflows/`).
- Add or update tests for every behaviour change.
- Keep the public API backward compatible; this is a published library following SemVer.
- Do not add new entries to `phpstan-baseline.neon` to hide errors; fix them. Only shrink the baseline.
- Do not commit `vendor/`; `composer.lock` is not tracked.
- Update `CHANGELOG.md` under `[Unreleased]` for every user-visible change (features, fixes, supported PHP versions, CI/tooling changes affecting contributors). Do this in the same commit/PR as the change.

## Skills

Repo-specific agent skills are in `.agents/skills/` (e.g. `check-ci`, `read-issue`).
