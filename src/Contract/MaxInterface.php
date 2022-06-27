<?php

declare(strict_types=1);

namespace Ekati\Contract;

use Ekati\Contract\DataInterface;

/**
 * Represents a structure that provides a maximum value finder
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
interface MaxInterface
{
    /**
     * Find the maximum element in a data structure.
     * A closure can be defined in order to compare two values.
     * The closure return value must follow the spaceship operator semantics.
     *
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return mixed
     * @phpstan-return ?DataInterface<T>
     */
    public function max(?\Closure $compare = null): mixed;
}
