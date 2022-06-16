<?php

declare(strict_types=1);

namespace Ekati\Contract;

use Ekati\Structure\BinaryTreeNode;

/**
 * A base interface for binary tree iterators
 *
 * @tempate T
 * @extends \Iterator<null, ?BinaryTreeNode>
 * @author Theodoros Papadopoulos
 */
interface BinaryTreeIterator extends \Iterator
{
    /**
     * Visit each tree node and apply a function to its data
     *
     * @param \Closure $closure a function to apply to the tree's elements
     * @return void
     */
    public function traverse(\Closure $closure): void;
}
