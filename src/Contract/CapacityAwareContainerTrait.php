<?php

declare(strict_types=1);

namespace Ekati\Contract;

use Ekati\Contract\SizeAwareContainerTrait;

/**
 * Add capacity awareness to a container
 *
 * @author Theodoros Papadopoulos
 */
trait CapacityAwareContainerTrait
{
    use SizeAwareContainerTrait;

    /**
     * The maximum number of elements a container can hold
     *
     * @var int
     */
    private int $capacity;

    /**
     * Get the container maximum size
     *
     * @return int
     */
    public function capacity(): int
    {
        return $this->capacity;
    }

    /**
     * Checks if the container has reached its maximum number of elements
     *
     * @return bool
     */
    public function full(): bool
    {
        return ($this->size === $this->capacity);
    }
}
