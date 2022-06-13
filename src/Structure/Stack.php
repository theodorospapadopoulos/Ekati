<?php

declare(strict_types=1);

namespace Ekati\Structure;

use Ekati\Exception\UnderflowException;

/**
 * A Stack (LIFO) implementation
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
class Stack
{
    /**
     * The number of elements in the stack
     * @var int
     */
    private int $size;

    /**
     * THe container that holds the elements
     * @phpstan-var array<T>
     * @var array[]
     */
    private array $container;

    /**
     * Stack constructor
     */
    public function __construct()
    {
        $this->size = 0;
        $this->container = [];
    }

    /**
     * Checks if the the stack has no elements
     *
     * @return bool, True if stack is empty
     */
    public function empty(): bool
    {
        return ($this->size == 0);
    }

    /**
     * The number of elements in the stack
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }

    /**
     * Returns the last inserted element without removing it
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function top(): mixed
    {
        if ($this->size == 0) {
            throw new UnderflowException();
        }

        return $this->container[$this->size - 1];
    }

    /**
     * Removes and returns the last inserted element from the stack
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function pop(): mixed
    {
        if ($this->size == 0) {
            throw new UnderflowException();
        }

        $element = $this->container[--$this->size];
        unset($this->container[$this->size]);

        return $element;
    }

    /**
     * Add a new element at the top of the stack
     *
     * @param mixed $element
     * @phpstan-param T $element
     * @return void
     */
    public function push(mixed $element): void
    {
        $this->container[] = $element;
        $this->size++;
    }
}
