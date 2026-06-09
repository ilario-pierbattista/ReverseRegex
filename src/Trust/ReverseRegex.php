<?php

declare(strict_types=1);

namespace Trust;

use ReverseRegex\Exception;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;
use ReverseRegex\Random\SimpleRandom;

/**
 * Trust PSP helper to simplify string generation from regex.
 */
final class ReverseRegex
{
    /**
     * @throws Exception
     */
    public function generate(string $regex): string
    {
        $result = null;

        $parser = new Parser(
            new  Lexer($regex),
            new Scope(),
            new Scope()
        );

        $parser->parse()->getResult()->generate($result, new SimpleRandom());

        return $result;
    }
}
