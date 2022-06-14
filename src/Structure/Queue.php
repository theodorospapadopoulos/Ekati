<?php

declare(strict_types=1);

namespace Ekati\Structure;

use Ekati\Exception\UnderflowException;
use Ekati\Exception\OverflowException;
use Ekati\Exception\EmptyContainerException;
use Ekati\Contract\CapacityAwareContainerTrait;

/**
 * Implementation of a Queue (FIFO) structure.
 * The implementation follows the circular queue (ring buffer) paradigm.
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
class Queue
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
     * The front index of the queue where elements are popped
     *
     * @var int
     */
    private int $head;

    /**
     * The rear index of the queue where elements as pushed
     *
     * @var int
     */
    private int $tail;

    /**
     * Queue constructor
     */
    public function __construct(int $capacity = 0)
    {
        $this->size = 0;
        $this->capacity = ($capacity > 0) ? $capacity : static::DEFAULT_CAPACITY;
        $this->container = [];
        $this->head = 0;
        $this->tail = -1;
    }

    /**
     * Adds an element to the end of the queue
     *
     * @param mixed $element
     * @phpstan-param T $element
     * @return void
     * @throws OverflowException
     */
    public function push(mixed $element): void
    {
        if ($this->size === $this->capacity) {
            throw new OverflowException();
        }

        $this->tail = ($this->tail + 1) % $this->capacity;
        $this->container[$this->tail] = $element;
        $this->size++;
    }

    /**
     * Removes an element from the head of the queue and returns it
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function pop(): mixed
    {
        if ($this->size === 0) {
            throw new UnderflowException();
        }

        $element = $this->container[$this->head];
        $this->size--;

        if ($this->size > 0) {
            $this->head = ($this->head + 1) % $this->capacity;
            return $element;
        }

        $this->head = 0;
        $this->tail = -1;

        return $element;
    }

    /**
     * Get the front (head) element of the queue
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function front(): mixed
    {
        if ($this->size === 0) {
            throw new UnderflowException();
        }

        return $this->container[$this->head];
    }

    /**
     * Get the back (rear) element of the queue
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function back(): mixed
    {
        if ($this->size === 0) {
            throw new UnderflowException();
        }

        return $this->container[$this->tail];
    }
}
