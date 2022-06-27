<?php

declare(strict_types=1);

namespace Ekati\Iterator;

use Ekati\Iterator\BinaryTreeAbstractIterator;
use Ekati\Structure\BinaryTreeNode;

/**
 * Traverses a binary tree in post-order fashion (LRD)
 *
 * @template T
 * @extends BinaryTreeAbstractIterator<T>
 * @author Theodoros Papadopoulos
 */
class BinaryTreePostOrderIterator extends BinaryTreeAbstractIterator
{
    /**
     * @phpstan-var ?BinaryTreeNode<T>
     * @var ?BinaryTreeNode
     */
    private ?BinaryTreeNode $previous = null;

    /**
     * @phpstan-var ?BinaryTreeNode<T>
     * @var ?BinaryTreeNode
     */
    private ?BinaryTreeNode $run = null;

    /**
     * Put the current pointer to the beginning of the sequence.
     * For in-order this is the left-most node from the root
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->previous = null;

        $this->run = $this->root;
        while ($this->run !== null) {
            $this->stack->push($this->run);
            $this->run = $this->run->left();
        }

        $this->next();
    }

    /**
     * Move to the next tree node in a post-order fashion
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->stack->empty()) {
            $this->current = null;
            return;
        }

        while ($this->run === null) {
            $this->run = $this->stack->top();

            if ($this->run->right() === null || $this->run->right() === $this->previous) {
                $this->current = $this->run;
                $this->stack->pop();
                $this->previous = $this->run;
                $this->run = null;
                return;
            }

            $this->run = $this->run->right();
            while ($this->run !== null) {
                $this->stack->push($this->run);
                $this->run = $this->run->left();
            }
        }
    }

    /**
     * Visit each tree node in post-order sequence
     * and apply a function to its data.
     *
     * @param \Closure $closure a function to apply to the tree's elements
     * @phpstan-param \Closure(BinaryTreeNode<T>):bool $closure
     * @return void
     */
    public function traverse(\Closure $closure): void
    {
        parent::rewind();
        $this->previous = null;

        do {
            while ($this->current !== null) {
                $this->stack->push($this->current);
                $this->current = $this->current->left();
            }

            while ($this->current === null && !$this->stack->empty()) {
                $this->current = $this->stack->top();

                if ($this->current->right() === null || $this->current->right() === $this->previous) {
                    if (!$closure($this->current)) {
                        return;
                    }
                    $this->stack->pop();
                    $this->previous = $this->current;
                    $this->current = null;
                    continue;
                }

                $this->current = $this->current->right();
            }
        } while (!$this->stack->empty());
    }
}
