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
        $this->capacity = ($capacity > 0) ? $capacity : 0;
        $this->container = [];
        $this->head = 0;
        $this->tail = -1;
    }

    /**
     * Adds an element to the end of the queue.
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
        $this->tail++;
        if ($this->capacity > 0) {
            $this->tail %= $this->capacity;
        }

        $this->container[$this->tail] = $element;
        $this->size++;
    }

    /**
     * Removes an element from the head of the queue and returns it.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the empty() function for the
     * existence of any element in the queue. The opposite leads
     * to undefined behavior.
     *
     * @return mixed
     * @phpstan-return T
     */
    public function pop(): mixed
    {
        $element = $this->container[$this->head];
        $this->size--;

        if ($this->size > 0) {
            $this->head++;
            if ($this->capacity > 0) {
                $this->head %= $this->capacity;
            }
            return $element;
        }

        $this->head = 0;
        $this->tail = -1;

        return $element;
    }

    /**
     * Get the front (head) element of the queue.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the empty() function for the
     * existence of any element in the queue. The opposite leads
     * to undefined behavior.
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function front(): mixed
    {
        return $this->container[$this->head];
    }

    /**
     * Get the back (rear) element of the queue.
     * The function is intentionally unsafe for performance reasons.
     * Before using it check with the empty() function for the
     * existence of any element in the queue. The opposite leads
     * to undefined behavior.
     *
     * @return mixed
     * @phpstan-return T
     * @throws UnderflowException
     */
    public function back(): mixed
    {
        return $this->container[$this->tail];
    }
}
