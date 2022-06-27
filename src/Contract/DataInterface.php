<?php

declare(strict_types=1);

namespace Ekati\Contract;

/**
 * Object nodes that hold arbitrary data
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
interface DataInterface
{
    /**
     * @phpstan-return T
     * @return mixed
     */
    public function data(): mixed;
}
