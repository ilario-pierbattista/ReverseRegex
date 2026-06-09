<?php

declare(strict_types=1);

namespace Trust\Test;

use PHPUnit\Framework\TestCase;
use ReverseRegex\Exception;
use Trust\ReverseRegex;

final class ReverseRegexTest extends TestCase
{
    public function testGeneratesDifferentMatchingValuesForTheSameRegex(): void
    {
        $generator = new ReverseRegex();
        $values = [];

        for ($i = 0; $i < 20; ++$i) {
            $value = $generator->generate('[a-z]{20}');

            self::assertMatchesRegularExpression('/^[a-z]{20}$/', $value);
            $values[$value] = true;
        }

        self::assertGreaterThan(1, \count($values));
    }

    public function testAllowsAResultOfExactlyFortyCharacters(): void
    {
        $value = new ReverseRegex()->generate('[a-z]{40}');

        self::assertSame(40, mb_strlen($value));
        self::assertMatchesRegularExpression('/^[a-z]{40}$/', $value);
    }

    /**
     * @dataProvider oversizedRegexProvider
     */
    public function testRejectsRegexThatCanGenerateMoreThanFortyCharacters(string $regex): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Generated value cannot exceed 40 characters');

        new ReverseRegex()->generate($regex);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function oversizedRegexProvider(): iterable
    {
        yield 'fixed quantifier' => ['a{41}'];
        yield 'nested quantifiers' => ['(ab{20}){2}'];
        yield 'unbounded star' => ['a*'];
        yield 'unbounded plus' => ['a+'];
        yield 'oversized alternative' => ['a|b{41}'];
    }
}
