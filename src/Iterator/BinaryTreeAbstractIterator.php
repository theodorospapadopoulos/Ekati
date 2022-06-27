<?php

declare(strict_types=1);

namespace Ekati\Iterator;

use Ekati\Contract\BinaryTreeIterator;
use Ekati\Structure\BinaryTreeNode;
use Ekati\Structure\Stack;

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
     * A helper stack for traversing the tree nodes
     *
     * @phpstan-var Stack<BinaryTreeNode<T>>
     * @var array
     */
    protected Stack $stack;

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
        $this->stack = new Stack();
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
     * @phpstan-return BinaryTreeNode<T>|null
     * @return BinaryTreeNode|null
     */
    public function current(): ?BinaryTreeNode
    {
        return $this->current;
    }

    abstract public function next(): void;

    /**
     * @param \Closure $closure
     * @phpstan-param \Closure(BinaryTreeNode<T>):bool $closure
     */
    abstract public function traverse(\Closure $closure): void;
}
