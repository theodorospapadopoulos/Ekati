<?php

declare(strict_types=1);

namespace Ekati\Iterator;

use Ekati\Iterator\BinaryTreeAbstractIterator;
use Ekati\Structure\BinaryTreeNode;
use Ekati\Structure\Queue;

/**
 * Traverses a binary tree in post-order fashion (LRD)
 *
 * @template T
 * @extends BinaryTreeAbstractIterator<T>
 * @author Theodoros Papadopoulos
 */
class BinaryTreeLevelOrderIterator extends BinaryTreeAbstractIterator
{
    /**
     * @phpstan-var Queue<BinaryTreeNode<T>>
     * @var Queue
     */
    private Queue $queue;

    /**
     * Put the current pointer to the beginning of the sequence.
     * For in-order this is the left-most node from the root
     *
     * @return void
     */
    public function rewind(): void
    {
        parent::rewind();
        $this->queue = new Queue();
        $this->queue->push($this->root);
        $this->next();
    }

    /**
     * Move to the next tree node in a post-order fashion
     *
     * @return void
     */
    public function next(): void
    {
        if ($this->queue->empty()) {
            $this->current = null;
            return;
        }

        $this->current = $this->queue->pop();

        if ($this->current->left() !== null) {
            $this->queue->push($this->current->left());
        }

        if ($this->current->right() !== null) {
            $this->queue->push($this->current->right());
        }
    }

    /**
     * Visit each tree node in post-order sequence
     * and apply a function to its data.
     *
     * @param \Closure $closure a function to apply to the tree's elements
     * @return void
     */
    public function traverse(\Closure $closure): void
    {
        parent::rewind();
        $this->queue = new Queue();
        $this->queue->push($this->root);

        while (!$this->queue->empty()) {
            $this->current = $this->queue->pop();
            $closure($this->current->data());

            if ($this->current->left() !== null) {
                $this->queue->push($this->current->left());
            }

            if ($this->current->right() !== null) {
                $this->queue->push($this->current->right());
            }
        }
    }
}
