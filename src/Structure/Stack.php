<?php

declare(strict_types=1);

namespace Ekati\Structure;

use Ekati\Exception\UnderflowException;
use Ekati\Exception\OverflowException;
use Ekati\Contract\CapacityAwareContainerTrait;

/**
 * A Stack (LIFO) implementation
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
class Stack
{
    use CapacityAwareContainerTrait;

    /**
     * The container that holds the elements
     *
     * @phpstan-var array<T>
     * @var array[]
     */
    private array $container;

    /**
     * Stack constructor
     */
    public function __construct(int $capacity = 0)
    {
        $this->size = 0;
        $this->capacity = ($capacity > 0) ? $capacity : 0;
        $this->container = [];
    }

    /**
     * Add a new element at the top of the stack.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the full() function if the capacity
     * limit is reached (unless capacity is zero, so no limit exists).
     *
     * @param mixed $element
     * @phpstan-param T $element
     * @return void
     */
    public function push(mixed $element): void
    {
        $this->container[$this->size++] = $element;
    }

    /**
     * Removes and returns the last inserted element from the stack.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the empty() function for the
     * existence of any element in the stack. The opposite leads
     * to undefined behavior.
     *
     * @return mixed
     * @phpstan-return T
     */
    public function pop(): mixed
    {
        $element = $this->container[--$this->size];
        unset($this->container[$this->size]);

        return $element;
    }

    /**
     * Returns the last inserted element without removing it.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the empty() function for the
     * existence of any element in the stack. The opposite leads
     * to undefined behavior.
     *
     * @return mixed
     * @phpstan-return T
     */
    public function top(): mixed
    {
        return $this->container[$this->size - 1];
    }
}
