<?php

declare(strict_types=1);

namespace Ekati\Contract;

/**
 * A structure capable of deleting elements
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
interface DeleterInterface
{
    /**
     *
     * @param mixed $value the value to insert
     * @phpstan-param T $value
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return void
     */
    public function delete(mixed $value, ?\Closure $compare = null): void;
}
