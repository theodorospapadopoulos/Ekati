<?php

declare(strict_types=1);

namespace Ekati\Exception;

/**
 * Indicates an invalid action attempted on an entity
 * already in its maximum possible bound
 *
 * @author Theodoros Papadopoulos
 */
class OverflowException extends \Exception
{
}
