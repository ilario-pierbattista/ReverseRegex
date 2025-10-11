<?php

namespace ReverseRegex\Test;

use ReverseRegex\Exception as RegexException;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser\Quantifier;

class QuantifierParserTest extends Basic
{
    public function testQuantifierParserPatternA(): void
    {
        $pattern = '{1,5}';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(1, $scope->getMinOccurances());
        $this->assertEquals(5, $scope->getMaxOccurances());
    }

    public function testQuantiferSingleValue(): void
    {
        $pattern = '{5}';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(5, $scope->getMinOccurances());
        $this->assertEquals(5, $scope->getMaxOccurances());
    }

    public function testQuantiferSpacesIncluded(): void
    {
        $pattern = '{ 1 , 5 }';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(1, $scope->getMinOccurances());
        $this->assertEquals(5, $scope->getMaxOccurances());
    }

    public function testFailerAlphaCaracters(): void
    {
        $pattern = '{ 1 , 5a }';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();

        $this->expectException(RegexException::class);
        $this->expectExceptionMessage('Quantifier expects and integer compitable string');

        $qual->parse($scope, $scope, $lexer);
    }

    public function testFailerMissingMaximumCaracters(): void
    {
        $pattern = '{ 1 ,}';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();

        $this->expectException(RegexException::class);
        $this->expectExceptionMessage('Quantifier expects and integer compitable string');

        $qual->parse($scope, $scope, $lexer);
    }

    public function testFailerMissingMinimumCaracters(): void
    {
        $pattern = '{,1}';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();

        $this->expectException(RegexException::class);
        $this->expectExceptionMessage('Quantifier expects and integer compitable string');

        $qual->parse($scope, $scope, $lexer);
    }

    public function testMissingClosureCharacter(): void
    {
        $pattern = '{1,1';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();

        $this->expectException(RegexException::class);
        $this->expectExceptionMessage('Closing quantifier token `}` not found');

        $qual->parse($scope, $scope, $lexer);
    }

    public function testNestingQuantifiers(): void
    {
        $pattern = '{1,1{1,1}';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();

        $this->expectException(RegexException::class);
        $this->expectExceptionMessage('Nesting Quantifiers is not allowed');

        $qual->parse($scope, $scope, $lexer);
    }

    public function testStarQuantifier(): void
    {
        $pattern = 'az*';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();

        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(0, $scope->getMinOccurances());
        $this->assertEquals(\PHP_INT_MAX, $scope->getMaxOccurances());
    }

    public function testCrossQuantifier(): void
    {
        $pattern = 'az+';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();
        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(1, $scope->getMinOccurances());
        $this->assertEquals(\PHP_INT_MAX, $scope->getMaxOccurances());
    }

    public function testQuestionQuantifier(): void
    {
        $pattern = 'az?';
        $lexer = new Lexer($pattern);
        $scope = new Scope();
        $qual = new Quantifier();

        $lexer->moveNext();
        $lexer->moveNext();
        $lexer->moveNext();
        $qual->parse($scope, $scope, $lexer);

        $this->assertEquals(0, $scope->getMinOccurances());
        $this->assertEquals(1, $scope->getMaxOccurances());
    }
}
// End of File
