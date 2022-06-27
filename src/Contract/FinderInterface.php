<?php

declare(strict_types=1);

namespace Ekati\Contract;

use Ekati\Contract\DataInterface;

/**
 * Represents a structure that provides searching of some value
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
interface FinderInterface
{
    /**
     * Search for an element in a data structure.
     * A closure can be defined in order to compare two values.
     * The closure return value must follow the spaceship operator semantics.
     *
     * @param mixed $value the value to search for
     * @phpstan-param T $value
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return ?DataInterface
     * @phpstan-return ?DataInterface<T>
     */
    public function find($value, ?\Closure $compare = null): ?DataInterface;
}
