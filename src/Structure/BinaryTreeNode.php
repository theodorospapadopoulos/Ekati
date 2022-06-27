<?php

declare(strict_types=1);

namespace Ekati\Structure;

use Ekati\Contract\DataInterface;
use Ekati\Iterator\BinaryTreeLevelOrderIterator;

/**
 * Implementation of a generic Binary Tree Node
 *
 * @template T
 * @implements DataInterface<T>
 * @author Theodoros Papadopoulos
 */
class BinaryTreeNode implements DataInterface
{
    /**
     * Holds the node's data
     *
     * @phpstan-var T
     * @var mixed
     */
    private $data;

    /**
     * The node's parent
     *
     * @phpstan-var BinaryTreeNode<T>|null
     * @var BinaryTreeNode|null
     */
    private ?BinaryTreeNode $parent;

    /**
     * The node's left child
     *
     * @phpstan-var BinaryTreeNode<T>|null
     * @var BinaryTreeNode|null
     */
    private ?BinaryTreeNode $left;

    /**
     * The node's right child
     *
     * @phpstan-var BinaryTreeNode<T>|null
     * @var BinaryTreeNode|null
     */
    private ?BinaryTreeNode $right;

    /**
     * Constructor
     *
     * @phpstan-param T $data
     * @param mixed $data
     * @phpstan-param BinaryTreeNode<T>|null $parent
     * @param BinaryTreeNode|null $parent
     */
    public function __construct(mixed $data, ?BinaryTreeNode $parent = null)
    {
        $this->data = $data;
        $this->parent = $parent;
        $this->left = null;
        $this->right = null;
    }

    /**
     * Get the node's data
     *
     * @phpstan-return T
     * @return mixed
     */
    public function data(): mixed
    {
        return $this->data;
    }

    /**
     * Get the parent node
     *
     * @phpstan-return BinaryTreeNode<T>|null
     * @return BinaryTreeNode|null
     */
    public function parent(): ?BinaryTreeNode
    {
        return $this->parent;
    }

    /**
     * Get the left child
     *
     * @phpstan-return BinaryTreeNode<T>|null
     * @return BinaryTreeNode|null
     */
    public function left(): ?BinaryTreeNode
    {
        return $this->left;
    }

    /**
     * Get the right child
     *
     * @phpstan-return BinaryTreeNode<T>|null
     * @return BinaryTreeNode|null
     */
    public function right(): ?BinaryTreeNode
    {
        return $this->right;
    }

    /**
     * Alter the node's data
     *
     * @param mixed $data
     * @phpstan-param T $data
     * @return static
     */
    public function setData($data): static
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Attach node to a parent node
     *
     * @phpstan-param BinaryTreeNode<T>|null $parent
     * @param BinaryTreeNode|null $parent
     * @return static
     */
    public function setParent(?BinaryTreeNode $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * Alter the left child
     *
     * @phpstan-param BinaryTreeNode<T>|null $left
     * @param BinaryTreeNode|null $left
     * @return static
     */
    public function setLeft(?BinaryTreeNode $left): static
    {
        $this->left = $left;
        $left?->setParent($this);
        return $this;
    }

    /**
     * Alter the right child
     *
     * @phpstan-param BinaryTreeNode<T>|null $right
     * @param BinaryTreeNode|null $right
     * @return static
     */
    public function setRight(?BinaryTreeNode $right): static
    {
        $this->right = $right;
        $right?->setParent($this);
        return $this;
    }
}
