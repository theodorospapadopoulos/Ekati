<?php

declare(strict_types=1);

namespace Tests\Iterator;

use PHPUnit\Framework\TestCase;
use Ekati\Structure\BinaryTreeNode;
use Ekati\Structure\BinaryTree;
use Ekati\Iterator\BinaryTreePreOrderIterator;
use Ekati\Iterator\BinaryTreeInOrderIterator;
use Ekati\Iterator\BinaryTreePostOrderIterator;
use Ekati\Iterator\BinaryTreeLevelOrderIterator;

/**
 * Tests for the Binary Tree Node
 *
 * @author Theodoros Papadopoulos
 */
class BinaryTreeNodeTest extends TestCase
{
    /**
     *
     * @phpstan-var BinaryTreeNode<int>
     * @var BinaryTree
     */
    private $tree;

    protected function setUp(): void
    {
        $this->tree = new BinaryTree(1);
        $this->tree->setLeft(
            (new BinaryTreeNode(2))
                ->setLeft(new BinaryTreeNode(4))
                ->setRight(
                    (new BinaryTreeNode(5))
                        ->setLeft(new BinaryTreeNode(7))
                        ->setRight(new BinaryTreeNode(8))
                )
        )->setRight(
            (new BinaryTreeNode(3))
                ->setLeft(
                    (new BinaryTreeNode(6))
                        ->setLeft(new BinaryTreeNode(9))
                        ->setRight(new BinaryTreeNode(10))
                )
        );
    }

    public function testStructure(): void
    {
        $this->assertSame($this->tree->left()->parent(), $this->tree);
        $this->assertSame($this->tree->right()->parent(), $this->tree);
    }

    public function testPreOrderTraversal(): void
    {
        $iterator = new BinaryTreePreOrderIterator($this->tree);
        $expected = [1, 2, 4, 5, 7, 8, 3, 6, 9, 10];

        // Use PHP iterator traversal
        $elements = [];
        foreach ($iterator as $node) {
            $elements[] = $node->data();
        }

        $this->assertEquals($expected, $elements);

        // Use direct traversal function (this is at least twice as fast)
        $elements = [];
        $iterator->traverse(function($node) use (&$elements) {
            $elements[] = $node->data();
            return true;
        });

        $this->assertEquals($expected, $elements);
    }

    public function testInOrderTraversal(): void
    {
        $iterator = new BinaryTreeInOrderIterator($this->tree);
        $expected = [4, 2, 7, 5, 8, 1, 9, 6, 10, 3];

        // Use PHP iterator traversal
        $elements = [];
        foreach ($iterator as $node) {
            $elements[] = $node->data();
        }

        $this->assertEquals($expected, $elements);

        // Use direct traversal function (this is at least twice as fast)
        $elements = [];
        $iterator->traverse(function($node) use (&$elements) {
            $elements[] = $node->data();
            return true;
        });

        $this->assertEquals($expected, $elements);
    }

    public function testPostOrderTraversal(): void
    {
        $iterator = new BinaryTreePostOrderIterator($this->tree);
        $expected = [4, 7, 8, 5, 2, 9, 10, 6, 3, 1];

        // Use PHP iterator traversal
        $elements = [];
        foreach ($iterator as $node) {
            $elements[] = $node->data();
        }

        $this->assertEquals($expected, $elements);

        // Use direct traversal function (this is at least twice as fast)
        $elements = [];
        $iterator->traverse(function($node) use (&$elements) {
            $elements[] = $node->data();
            return true;
        });

        $this->assertEquals($expected, $elements);
    }

    public function testLevelOrderTraversal(): void
    {
        $iterator = new BinaryTreeLevelOrderIterator($this->tree);
        $expected = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        // Use PHP iterator traversal
        $elements = [];
        foreach ($iterator as $node) {
            $elements[] = $node->data();
        }

        $this->assertEquals($expected, $elements);

        // Use direct traversal function (this is at least twice as fast)
        $elements = [];
        $iterator->traverse(function($node) use (&$elements) {
            $elements[] = $node->data();
            return true;
        });

        $this->assertEquals($expected, $elements);
    }
}
