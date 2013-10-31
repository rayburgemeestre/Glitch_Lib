<?php
/**
 * Glitch_LazyString can be used as a string object, and will 'lazy-construct' the string from given lambda function.
 *
 * Example usage:
 * <pre>
 * function ExpensiveFunctionThatReturnsString()
 * {
 *     sleep(10);
 *     return 'Hello world';
 * }
 *
 * $normalString = ExpensiveFunctionThatReturnsString();
 * $lazyString = new Glitch_LazyString(function () { return ExpensiveFunctionThatReturnsString(); });
 *
 * var_dump($normalString); // commenting this var_dump won't prevent the expensive function call
 * var_dump($lazyString);   // commenting this var_dump will prevent the expensive function call,
 *                          //  as Glitch_LazyString::__toString() will never be called.
 * </pre>
 */
class Glitch_LazyString
{
    /**
     * @var function $lambda
     */
    private $lambda = null;

    /**
     * @param function $lambda
     * @throws InvalidArgumentException  $lambda is not callable
     */
    public function __construct($lambda)
    {
        if ( ! is_callable($lambda))
            throw new \InvalidArgumentException;

        $this->lambda = $lambda;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $func = $this->lambda;
        return $func();
    }
}
