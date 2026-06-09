<?php

declare(strict_types=1);

namespace Trust;

use PHPStats\Generator\GeneratorInterface;
use InvalidArgumentException;
use LengthException;
use ReverseRegex\Exception as LegacyException;
use ReverseRegex\Generator\LiteralScope;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;

/**
 * Trust PSP helper to simplify string generation from regex.
 */
final class ReverseRegex
{
    private const int MAX_RESULT_LENGTH = 40;

    /**
     * @throws InvalidArgumentException
     * @throws LengthException
     */
    public function generate(string $regex): string
    {
        try {
            $result = '';

            $parser = new Parser(
                new Lexer($regex),
                new Scope(),
                new Scope(),
            );

            $scope = $parser->parse()->getResult();
            $this->validateRegexScope($scope);

            $result = $scope->generate($result, $this->secureRandomGenerator());
            $this->validateResult($result);

            return $result;
        } catch (LegacyException $exception) {
            throw new InvalidArgumentException($exception->getMessage(), 0, $exception);
        }
    }

    private function validateRegexScope(Scope $scope): void
    {
        if ($this->maximumLength($scope) > self::MAX_RESULT_LENGTH) {
            throw new LengthException(\sprintf(
                'Generated value cannot exceed %d characters',
                self::MAX_RESULT_LENGTH,
            ));
        }
    }

    private function validateResult(string $result): void
    {
        if (mb_strlen($result) > self::MAX_RESULT_LENGTH) {
            throw new LengthException(\sprintf(
                'Generated value cannot exceed %d characters',
                self::MAX_RESULT_LENGTH,
            ));
        }
    }

    private function maximumLength(Scope $scope): int
    {
        $contentLength = $this->getContentLength($scope);
        $repetitions = max($scope->getMinOccurances(), $scope->getMaxOccurances());

        if ($contentLength === 0 || $repetitions === 0) {
            return 0;
        }

        if ($repetitions > intdiv(self::MAX_RESULT_LENGTH, $contentLength)) {
            return self::MAX_RESULT_LENGTH + 1;
        }

        return $contentLength * $repetitions;
    }

    private function getContentLength(Scope $scope): int
    {
        if ($scope instanceof LiteralScope) {
            return 1;
        }

        $contentLength = 0;

        if ($scope->usingAlternatingStrategy() === true) {
            foreach ($scope as $child) {
                $contentLength = max($contentLength, $this->maximumLength($child));
            }

            return $contentLength;
        }

        foreach ($scope as $child) {
            $contentLength += $this->maximumLength($child);

            if ($contentLength > self::MAX_RESULT_LENGTH) {
                return self::MAX_RESULT_LENGTH + 1;
            }
        }

        return $contentLength;
    }

    private function secureRandomGenerator(): GeneratorInterface
    {
        return new class implements GeneratorInterface {
            public function generate($min = 0, $max = null): int
            {
                return random_int((int) $min, (int) ($max ?? \PHP_INT_MAX));
            }

            public function seed($seed = null): void {}

            public function max(): float
            {
                return (float) \PHP_INT_MAX;
            }
        };
    }
}
