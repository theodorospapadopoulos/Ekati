<?php

declare(strict_types=1);

namespace Ekati\Structure;

use Ekati\Structure\BinaryTreeNode;
use Ekati\Iterator\BinaryTreeLevelOrderIterator;
use Ekati\Contract\MinInterface;
use Ekati\Contract\MaxInterface;
use Ekati\Contract\FinderInterface;
use Ekati\Contract\InserterInterface;
use Ekati\Contract\DeleterInterface;

/**
 * Implementation of various algorithms concerning a BinaryTree
 *
 * @template T
 * @implements MinInterface<T>
 * @implements MaxInterface<T>
 * @implements FinderInterface<T>
 * @implements InserterInterface<T>
 * @author Theodorros Papadopoulos
 */
class BinaryTree implements
    MinInterface,
    MaxInterface,
    FinderInterface,
    InserterInterface,
    DeleterInterface
{
    /**
     * The root node of the tree
     *
     * @var BinaryTreeNode|null
     * @phpstan-var BinaryTreeNode<T>|null
     */
    private ?BinaryTreeNode $root;

    /**
     * Constructor
     *
     * @param BinaryTreeNode|null $root the root node of the tree
     * @phpstan-param BinaryTreeNode<T>|null $root
     */
    public function __construct(?BinaryTreeNode $root = null)
    {
        $this->attach($root);
    }

    /**
     * Alter the tree's root node
     *
     * @param BinaryTreeNode|null $root
     * @phpstan-param BinaryTreeNode<T>|null $root
     * @return void
     */
    public function attach(?BinaryTreeNode $root = null): void
    {
        $this->root = $root;
    }

    /**
     * Fetch the tree's root node
     *
     * @phpstan-return BinaryTreeNode<T>|null
     * @return BinaryTreeNode|null
     */
    public function root(): ?BinaryTreeNode
    {
        return $this->root;
    }

    /**
     * Find the minimum element it the tree.
     * A closure can be defined in order to compare two node values.
     * The closure return value must follow the spaceship operator semantics.
     * If no closure is provided a standard closure with spaceship
     * operator comparison is provided.
     *
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return ?BinaryTreeNode
     * @phpstan-return ?BinaryTreeNode<T>
     */
    public function min(?\Closure $compare = null): ?BinaryTreeNode
    {
        if ($this->root === null) {
            return null;
        }

        $iterator = new BinaryTreeLevelOrderIterator($this->root);
        if ($compare === null) {
            $compare = function ($left, $right) {
                return $left <=> $right;
            };
        }

        $min = $this->root;
        $iterator->traverse(function ($node) use (&$min, $compare) {
            if ($compare($min->data(), $node->data()) > 0) {
                $min = $node;
            }
            return true;
        });

        return $min;
    }

    /**
     * Find the maximum element it the tree.
     * A closure can be defined in order to compare two node values.
     * The closure return value must follow the spaceship operator semantics.
     * If no closure is provided a standard closure with spaceship
     * operator comparison is provided.
     *
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return ?BinaryTreeNode
     * @phpstan-return ?BinaryTreeNode<T>
     */
    public function max(?\Closure $compare = null): ?BinaryTreeNode
    {
        if ($this->root === null) {
            return null;
        }

        $iterator = new BinaryTreeLevelOrderIterator($this->root);
        if ($compare === null) {
            $compare = function ($left, $right) {
                return $left <=> $right;
            };
        }

        $max = $this->root;
        $iterator->traverse(function ($node) use (&$max, $compare) {
            if ($compare($max->data(), $node->data()) < 0) {
                $max = $node;
            }
            return true;
        });

        return $max;
    }

    /**
     * Search for an element in the tree.
     * A closure can be defined in order to compare two values.
     * The closure return value must follow the spaceship operator semantics.
     *
     * @param mixed $value the value to search for
     * @phpstan-param T $value
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return ?BinaryTreeNode
     * @phpstan-return ?BinaryTreeNode<T>
     */
    public function find($value, ?\Closure $compare = null): ?BinaryTreeNode
    {
        if ($this->root === null) {
            return null;
        }

        $iterator = new BinaryTreeLevelOrderIterator($this->root);
        if ($compare === null) {
            $compare = function ($left, $right) {
                return $left <=> $right;
            };
        }

        /** @phpstan-var ?BinaryTreeNode<T> */
        $found = null;
        $iterator->traverse(function ($node) use (&$found, $value, $compare) {
            if ($compare($value, $node->data()) === 0) {
                $found = $node;
                return false;
            }
            return true;
        });

        return $found;
    }

    /**
     *
     * @param mixed $value the value to insert
     * @phpstan-param T $value
     * @return BinaryTreeNode
     * @phpstan-return BinaryTreeNode<T>
     */
    public function insert(mixed $value): BinaryTreeNode
    {
        if ($this->root === null) {
            $node = new BinaryTreeNode($value);
            $this->root = $node;
            return $node;
        }

        $newNode = $this->root;
        $iterator = new BinaryTreeLevelOrderIterator($this->root);
        $iterator->traverse(function (BinaryTreeNode $node) use ($value, &$newNode) {
            if ($node->left() === null) {
                $newNode = new BinaryTreeNode($value);
                $node->setLeft($newNode);
                return false;
            }

            if ($node->right() === null) {
                $newNode = new BinaryTreeNode($value);
                $node->setRight($newNode);
                return false;
            }

            return true;
        });

        return $newNode;
    }

    /**
     *
     * @param mixed $value the value to insert
     * @phpstan-param T $value
     * @param ?\Closure $compare
     * @phstan-param \Closure(T,T):int|null $compare
     * @return void
     */
    public function delete(mixed $value, ?\Closure $compare = null): void
    {
        $delNode = $this->find($value, $compare);
        if ($delNode === null) {
            return;
        }

        $deepestNode = $this->deepestNode();
        if ($delNode !== $deepestNode) {
            $delNode->setData($deepestNode?->data());
        }

        $this->deleteLeaf($deepestNode);
    }

    /**
     * Find the deepest node in the tree (lower right node)
     *
     * @return BinaryTreeNode|null
     * @phpstan-return BinaryTreeNode<T>|null

     */
    protected function deepestNode(): ?BinaryTreeNode
    {
        if ($this->root === null) {
            return null;
        }

        $deepestNode = $this->root;
        $iterator = new BinaryTreeLevelOrderIterator($this->root);
        $iterator->traverse(function (BinaryTreeNode $node) use (&$deepestNode) {
            $deepestNode = $node;
            return true;
        });

        return $deepestNode;
    }

    /**
     * Remove a leaf node
     *
     * @param BinaryTreeNode $node
     * @phpstan-param BinaryTreeNode<T> $node
     * @return void
     */
    protected function deleteLeaf(?BinaryTreeNode $node): void
    {
        if ($node !== null) {
            $parent = $node->parent();
            if ($parent !== null) {
                if ($parent->left() === $node) {
                    $parent->setLeft(null);
                }

                if ($parent->right() === $node) {
                    $parent->setRight(null);
                }
            }

            unset($node);
        }
    }
}
