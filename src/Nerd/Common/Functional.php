<?php

namespace Nerd\Common\Functional;

/**
 * Decorates given function with tail recursion optimization.
 *
 * I took solution here https://gist.github.com/beberlei/4145442
 * but reworked it for use without classes.
 *
 * @param callable $fn
 * @return \Closure
 */
function tail(callable $fn)
{
    $underCall = false;
    $pool = [];
    return function (...$args) use (&$fn, &$underCall, &$pool) {
        $result = null;
        $pool[] = $args;
        if (!$underCall) {
            $underCall = true;
            while ($pool) {
                $head = array_shift($pool);
                $result = $fn(...$head);
            }
            $underCall = false;
        }
        return $result;
    };
}
