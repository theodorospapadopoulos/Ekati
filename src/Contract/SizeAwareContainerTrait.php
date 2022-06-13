<?php

declare(strict_types=1);

namespace Ekati\Contract;

/**
 * Add size awareness to a class
 *
 * @author Theodoros Papadopoulos
 */
trait SizeAwareContainerTrait
{
    /**
     * The number of elements
     * @var int
     */
    private int $size;

    /**
     * Checks if the container has no elements
     *
     * @return bool, True if container is empty
     */
    public function empty(): bool
    {
        return ($this->size == 0);
    }

    /**
     * The number of elements in the container
     *
     * @return int
     */
    public function size(): int
    {
        return $this->size;
    }
}
