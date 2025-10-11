<?php

namespace ReverseRegex\Generator;

use PHPStats\Generator\GeneratorInterface;

/**
 *  Conext interface for Generator.
 *
 *  @author Lewis Dyer <getintouch@icomefromthenet.com>
 *
 *  @since 0.0.1
 */
interface ContextInterface
{
    /**
     *  Generate a text string appending to result arguments.
     *
     * @param string $result
     */
    public function generate(&$result, GeneratorInterface $generator);
}

// End of File
