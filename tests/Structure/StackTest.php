<?php

declare(strict_types=1);

namespace Tests\Structure;

use PHPUnit\Framework\TestCase;
use Ekati\Structure\Stack;
use Ekati\Exception\UnderflowException;

/**
 * Tests for the Stack implementation
 *
 * @author Theodoros Papadopoulos
 */
class StackTest extends TestCase
{
    /**
     * @phpstan-var \Ekati\Structure\Stack<int>
     * @var \Ekati\Structure\Stack
     */
    private $stack;

    protected function setUp(): void
    {
        $this->stack = new Stack();
    }

    public function testEmptyOnInitialization(): void
    {
        $this->assertTrue($this->stack->empty());
        $this->assertSame(0, $this->stack->size());
    }

    public function testTopThrowsExceptionOnEmptyStack(): void
    {
        $this->expectException(UnderflowException::class);
        $this->stack->top();
    }

    public function testPopThrowsExceptionOnEmptyStack(): void
    {
        $this->expectException(UnderflowException::class);
        $this->stack->pop();
    }

    public function testPushAndPop(): void
    {
        $this->stack->push(3);
        $this->assertSame(1, $this->stack->size());

        $this->stack->push(5);
        $this->assertSame(2, $this->stack->size());

        $this->assertSame(5, $this->stack->pop());
        $this->assertSame(1, $this->stack->size());
        $this->assertFalse($this->stack->empty());

        $this->assertSame(3, $this->stack->pop());
        $this->assertSame(0, $this->stack->size());
        $this->assertTrue($this->stack->empty());
    }

    public function testPushAndTop(): void
    {
        $this->stack->push(15);
        $this->assertSame(1, $this->stack->size());
        $this->assertSame(15, $this->stack->top());
        $this->assertSame(1, $this->stack->size());
    }
}
