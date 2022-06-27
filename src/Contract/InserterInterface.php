<?php

declare(strict_types=1);

namespace Ekati\Contract;

use Ekati\Contract\DataInterface;

/**
 * A structure capable of inserting new elements
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
interface InserterInterface
{
    /**
     *
     * @param mixed $value the value to insert
     * @phpstan-param T $value
     * @return DataInterface
     * @phpstan-return DataInterface<T>
     */
    public function insert(mixed $value): DataInterface;
}
