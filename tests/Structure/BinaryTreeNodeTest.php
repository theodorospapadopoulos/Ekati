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
     * @var BinaryTreeNode
     */
    private $tree;

    protected function setUp(): void
    {
        $this->tree = new BinaryTreeNode(1);
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

    public function testFindMinimum(): void
    {
        $tree = new BinaryTree();
        $this->assertNull($tree->min());

        $tree->attach($this->tree);
        $this->assertEquals(1, $tree->min()->data());
    }

    public function testFindMaximum(): void
    {
        $tree = new BinaryTree();
        $this->assertNull($tree->max());

        $tree->attach($this->tree);
        $this->assertEquals(10, $tree->max()->data());
    }

    public function testFindValue(): void
    {
        $tree = new BinaryTree();
        $this->assertNull($tree->find(4));

        $tree->attach($this->tree);
        $this->assertNull($tree->find(27));
        $this->assertEquals(7, $tree->find(7)->data());
    }

    public function testInsert(): void
    {
        $tree = new BinaryTree();
        $node = $tree->insert(3);
        $this->assertSame($tree->root(), $node);

        $node = $tree->insert(5);
        $this->assertSame($tree->root()->left(), $node);

        $node = $tree->insert(1);
        $this->assertSame($tree->root()->right(), $node);

        $node = $tree->insert(15);
        $this->assertSame($tree->root()->left()->left(), $node);

        $node = $tree->insert(9);
        $this->assertSame($tree->root()->left()->right(), $node);

        $this->assertEquals([3, 5, 15, 9, 1], (new BinaryTreePreOrderIterator($tree->root()))->toArray());
        $this->assertEquals([15, 5, 9, 3, 1], (new BinaryTreeInOrderIterator($tree->root()))->toArray());
        $this->assertEquals([15, 9, 5, 1, 3], (new BinaryTreePostOrderIterator($tree->root()))->toArray());
        $this->assertEquals([3, 5, 1, 15, 9], (new BinaryTreeLevelOrderIterator($tree->root()))->toArray());
    }
}
