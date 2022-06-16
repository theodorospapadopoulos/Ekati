<?php

declare(strct_types=1);

namespace Ekati\Iterator;

use Ekati\Contract\BinaryTreeIterator;
use Ekati\Structure\BinaryTreeNode;

/**
 * A base class for binary tree iterators
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
abstract class BinaryTreeAbstractIterator implements BinaryTreeIterator
{
    /**
     * Te root of the  binary tree to traverse
     *
     * @phpstan-var BinaryTreeNode<T>
     * @var BinaryTreeNode
     */
    protected BinaryTreeNode $root;

    /**
     * The currently accessed node
     *
     * @phpstan-var BinaryTreeNode<T>|null
     * @var BinaryTreeNode|null
     */
    protected ?BinaryTreeNode $current;

    /**
     * A helper stack for traversing the nodes
     *
     * @phpstan-var array<BinaryTreeNode<T>>
     * @var array
     */
    private array $stack;

    /**
     * The current size o the stack
     * @var int
     */
    private int $stackSize;

    /**
     * Constructor
     *
     * @phpstan-param BinaryTreeNode<T> $root
     * @param BinaryTreeNode $root the binary tree to traverse
     */
    public function __construct(BinaryTreeNode $root)
    {
        $this->root = $root;
        $this->rewind();
    }

    /**
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->current = $this->root;
        $this->stack = [];
        $this->stackSize = 0;
    }

    /**
     *
     * @return bool
     */
    public function valid(): bool
    {
        return ($this->current !== null);
    }

    /**
     *
     * @return mixed
     */
    public function key(): mixed
    {
        return null;
    }

    /**
     *
     * @phpstan-return T|null
     * @return mixed
     */
    public function current(): mixed
    {
        return $this->current?->data() ?? null;
    }

    abstract public function next(): void;
    abstract public function traverse(\Closure $closure): void;

    /**
     * Adds a tree node to the top of the helper stack
     *
     * @phpstan-param BinaryTreeNode<T> $node
     * @param BinaryTreeNode $node
     * @return void
     */
    protected function stackPush(BinaryTreeNode $node): void
    {
        $this->stack[$this->stackSize++] = $node;
    }

    /**
     * Removes a tree node from the helper stack.
     * It is an unsafe function, call stackEmpty() before
     *
     * @phpstan-return BinaryTreeNode<T>
     * @return BinaryTreeNode
     */
    protected function stackPop(): BinaryTreeNode
    {
        $this->stackSize--;
        $node = $this->stack[$this->stackSize];
        unset($this->stack[$this->stackSize]);

        return $node;
    }

    protected function stackEmpty(): bool
    {
        return ($this->stackSize === 0);
    }
}
