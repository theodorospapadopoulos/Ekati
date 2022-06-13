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

    public const DEFAULT_CAPACITY = 1024;

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
        $this->capacity = ($capacity > 0) ? $capacity : static::DEFAULT_CAPACITY;
        $this->container = [];
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
        if ($this->size === $this->capacity) {
            throw new OverflowException();
        }

        $this->container[] = $element;
        $this->size++;
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
}
