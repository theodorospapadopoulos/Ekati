<?php

declare(strct_types=1);

namespace Ekati\Structure;

/**
 * Implementation of a generic Binary Tree Node
 *
 * @template T
 * @author Theodoros Papadopoulos
 */
class BinaryTreeNode
{
    /**
     * Holds the node's data
     *
     * @phpstan-var T
     * @var mixed
     */
    private $data;

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


    public function __construct(mixed $data)
    {
        $this->data = $data;
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
     * Alter the left child
     *
     * @phpstan-param BinaryTreeNode<T>|null $left
     * @param BinaryTreeNode|null $left
     * @return static
     */
    public function setLeft(?BinaryTreeNode $left): static
    {
        $this->left = $left;
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
        return $this;
    }
}
