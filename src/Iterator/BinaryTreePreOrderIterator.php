<?php

declare(strict_types=1);

namespace Ekati\Iterator;

use Ekati\Iterator\BinaryTreeAbstractIterator;
use Ekati\Structure\BinaryTreeNode;

/**
 * Traverses a binary tree in pre-order fashion (DLR)
 *
 * @template T
 * @extends BinaryTreeAbstractIterator<T>
 * @author Theodoros Papadopoulos
 */
class BinaryTreePreOrderIterator extends BinaryTreeAbstractIterator
{
    /**
     * Move to the next tree node in a pre-ordeer fashion
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->current !== null) {
            $this->stack->push($this->current);
            $this->current = $this->current->left();

            if ($this->current !== null) {
                return;
            }
        }

        if ($this->stack->empty()) {
            $this->current = null;
            return;
        }

        do {
            $this->current = $this->stack->pop()->right();
        } while ($this->current === null && $this->stack->empty() === false);
    }

    /**
     * Visit each tree node in pre-order sequence
     * and apply a function to its data.
     *
     * @param \Closure $closure a function to apply to the tree's elements
     * @return void
     */
    public function traverse(\Closure $closure): void
    {
        $this->rewind();

        while (1) {
            while ($this->current !== null) {
                $closure($this->current->data());
                $this->stack->push($this->current);
                $this->current = $this->current->left();
            }

            if ($this->stack->empty()) {
                break;
            }

            $this->current = $this->stack->pop()->right();
        }
    }
}
