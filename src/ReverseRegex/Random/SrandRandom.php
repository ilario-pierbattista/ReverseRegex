<?php

namespace ReverseRegex\Random;

/*
 * class SrandRandom
 *
 * Wrapper to mt_random with seed option
 *
 * Won't work when suhosin.srand.ignore = Off or suhosin.mt_srand.ignore = Off
 * is set.
 *
 * @author Lewis Dyer <getintouch@icomefromthenet.com>
 *
 * @internal
 */
class SrandRandom implements GeneratorInterface
{
    /**
     * @var int the seed to use on each pass
     */
    protected $seed;

    /**
     * @var int the max
     */
    protected $max;

    /**
     * @var int the min
     */
    protected $min;

    /*
     * __construct()
     *
     * @param integer $seed the starting seed
     * @return void
     * @access public
     */
    public function __construct($seed = 0)
    {
        $this->seed($seed);
    }

    /**
     *  Return the maxium random number.
     *
     * @return float
     */
    public function max($value = null)
    {
        if ($value === null && $this->max === null) {
            $max = mt_getrandmax();
        } elseif ($value === null) {
            $max = $this->max;
        } else {
            $max = $this->max = $value;
        }

        return $max;
    }

    public function min($value = null)
    {
        if ($value === null && $this->max === null) {
            $min = 0;
        } elseif ($value === null) {
            $min = $this->min;
        } else {
            $min = $this->min = $value;
        }

        return $min;
    }

    /**
     *  Generate a value between $min - $max.
     *
     * @param int $max
     * @param int $max
     */
    public function generate($min = 0, $max = null)
    {
        if ($max === null) {
            $max = $this->max;
        }

        if ($min === null) {
            $min = $this->min;
        }

        return mt_rand($min, $max);
    }

    /**
     *  Set the seed to use.
     *
     * @param $seed integer the seed to use
     */
    public function seed($seed = null)
    {
        $this->seed = $seed;
        mt_srand($this->seed);

        return $this;
    }
}
// End of File
