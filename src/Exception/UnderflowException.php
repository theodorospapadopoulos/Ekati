<?php

declare(strict_types=1);

namespace Ekati\Exception;

/**
 * Indicates an invalid action attempted on an entity
 * already in its lowest possible bound
 *
 * @author Theodoros Papadopoulos
 */
class UnderflowException extends \Exception
{
}
