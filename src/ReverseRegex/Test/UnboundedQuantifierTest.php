<?php

namespace ReverseRegex\Test;

use ReverseRegex\Exception as RegexException;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;

/**
 * Test cases for unbounded quantifier issues
 *
 * These tests are designed to reproduce and verify fixes for issues
 * related to unbounded quantifiers (*, +) that can cause infinite loops
 * or crashes in the generation process.
 */
class UnboundedQuantifierTest extends Basic
{
    /**
     * Test case for unbounded star quantifier issue
     *
     * This reproduces the issue reported in:
     * https://raw.githubusercontent.com/philippedev101/reverseregex-unbounded-repro/refs/heads/main/repro.php
     *
     * The regex pattern "[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*" contains an unbounded "*" quantifier
     * which should generate a valid string but may cause infinite loops or crashes.
     */
    public function testUnboundedStarQuantifierWithCharacterClass(): void
    {
        // This regex pattern represents a typical PHP variable name pattern
        // First character: letter, underscore, or extended ASCII (0x7f-0xff)
        // Following characters: letter, number, underscore, or extended ASCII (0x7f-0xff), zero or more times
        $expression = "[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*";

        $lexer = new Lexer($expression);
        $gen = new SimpleRandom(123); // Use a fixed seed for reproducible results
        $parser = new Parser($lexer, new Scope(), new Scope());

        $result = null;

        // This should generate a valid string without infinite loops or crashes
        // If the bug exists, this will likely hang or throw an exception
        try {
            $parser->parse()->getResult()->generate($result, $gen);

            // If we reach here, the generation succeeded
            $this->assertNotNull($result, "Generated result should not be null");
            $this->assertIsString($result, "Generated result should be a string");
            $this->assertNotEmpty($result, "Generated result should not be empty");

            // Verify the result matches the original pattern
            $this->assertMatchesRegularExpression('/^[a-zA-Z_\\x7f-\\xff][a-zA-Z0-9_\\x7f-\\xff]*$/', $result);

            echo "Successfully generated: " . $result . PHP_EOL;
        } catch (\Throwable $e) {
            // If we catch an exception, this demonstrates the bug
            $this->fail("Unbounded quantifier caused an exception: " . $e->getMessage());
        }
    }

    /**
     * Test case for simple unbounded star quantifier
     *
     * This tests a simpler case with just "a*" to see if the issue
     * is specific to character classes or affects all unbounded quantifiers.
     */
    public function testSimpleUnboundedStarQuantifier(): void
    {
        $expression = "a*";

        $lexer = new Lexer($expression);
        $gen = new SimpleRandom(456);
        $parser = new Parser($lexer, new Scope(), new Scope());

        $result = null;

        try {
            $parser->parse()->getResult()->generate($result, $gen);

            $this->assertNotNull($result, "Generated result should not be null");
            $this->assertIsString($result, "Generated result should be a string");

            // For "a*", result can be empty string or one or more 'a's
            $this->assertMatchesRegularExpression('/^a*$/', $result);

            echo "Simple a* generated: '" . $result . "'" . PHP_EOL;
        } catch (\Throwable $e) {
            $this->fail("Simple unbounded quantifier caused an exception: " . $e->getMessage());
        }
    }

    /**
     * Test case for unbounded plus quantifier
     *
     * This tests the "+" quantifier which is also unbounded but requires
     * at least one occurrence.
     */
    public function testUnboundedPlusQuantifier(): void
    {
        $expression = "[a-z]+";

        $lexer = new Lexer($expression);
        $gen = new SimpleRandom(789);
        $parser = new Parser($lexer, new Scope(), new Scope());

        $result = null;

        try {
            $parser->parse()->getResult()->generate($result, $gen);

            $this->assertNotNull($result, "Generated result should not be null");
            $this->assertIsString($result, "Generated result should be a string");
            $this->assertNotEmpty($result, "Generated result should not be empty for + quantifier");

            // For "[a-z]+", result must contain at least one lowercase letter
            $this->assertMatchesRegularExpression('/^[a-z]+$/', $result);

            echo "Plus quantifier [a-z]+ generated: " . $result . PHP_EOL;
        } catch (\Throwable $e) {
            $this->fail("Unbounded plus quantifier caused an exception: " . $e->getMessage());
        }
    }

    /**
     * Test multiple unbounded quantifiers in sequence
     *
     * This tests what happens when we have multiple unbounded quantifiers
     * in the same pattern.
     */
    public function testMultipleUnboundedQuantifiers(): void
    {
        $expression = "[a-z]*[0-9]*";

        $lexer = new Lexer($expression);
        $gen = new SimpleRandom(101112);
        $parser = new Parser($lexer, new Scope(), new Scope());

        $result = null;

        try {
            $parser->parse()->getResult()->generate($result, $gen);

            $this->assertNotNull($result, "Generated result should not be null");
            $this->assertIsString($result, "Generated result should be a string");

            // Result can be empty or contain letters followed by digits
            $this->assertMatchesRegularExpression('/^[a-z]*[0-9]*$/', $result);

            echo "Multiple quantifiers [a-z]*[0-9]* generated: '" . $result . "'" . PHP_EOL;
        } catch (\Throwable $e) {
            $this->fail("Multiple unbounded quantifiers caused an exception: " . $e->getMessage());
        }
    }
}
// End of File