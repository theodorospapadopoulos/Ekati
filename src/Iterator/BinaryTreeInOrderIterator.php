<?php

declare(strict_types=1);

namespace Ekati\Iterator;

use Ekati\Iterator\BinaryTreeAbstractIterator;
use Ekati\Structure\BinaryTreeNode;

/**
 * Traverses a binary tree in in-order fashion (LDR)
 *
 * @template T
 * @extends BinaryTreeAbstractIterator<T>
 * @author Theodoros Papadopoulos
 */
class BinaryTreeInOrderIterator extends BinaryTreeAbstractIterator
{
    /**
     * Helper to know if we previously popped from the stack.
     * This signals that we have to follow the right tree.
     *
     * @var bool
     */
    private bool $justPopped = false;

    /**
     * Put the current pointer to the beginning of the sequence.
     * For in-order this is the left-most node from the root
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->traverseLeftToEnd();
    }

    /**
     * Move to the next tree node in a in-order fashion
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->justPopped) {
            $this->justPopped = false;
            $this->current = $this->current?->right();

            if ($this->current !== null) {
                $this->traverseLeftToEnd();
                return;
            }
        }

        while ($this->current !== null) {
            $this->stack->push($this->current);
            $this->current = $this->current->left();
        }

        if ($this->stack->empty()) {
            $this->current = null;
            return;
        }

        $this->current = $this->stack->pop();
        $this->justPopped = true;
    }

    /**
     * Visit each tree node using in-order sequence
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
                $this->stack->push($this->current);
                $this->current = $this->current->left();
            }

            if ($this->stack->empty()) {
                break;
            }

            $this->current = $this->stack->pop();
            $closure($this->current->data());
            $this->current = $this->current->right();
        }
    }

    /**
     * Given a starting node find its left-most node down the tree
     *
     * @return void
     */
    private function traverseLeftToEnd(): void
    {
        while ($this->current !== null) {
            $this->stack->push($this->current);
            $this->current = $this->current->left();
        }

        $this->current = $this->stack->pop();
        $this->justPopped = true;
    }
}
