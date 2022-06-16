<?php

declare(strict_types=1);

namespace Tests\Structure;

use PHPUnit\Framework\TestCase;
use Ekati\Structure\Stack;
use Ekati\Exception\UnderflowException;
use Ekati\Exception\OverflowException;

/**
 * Tests for the Stack implementation
 *
 * @author Theodoros Papadopoulos
 */
class StackTest extends TestCase
{
    private const CAPACITY = 2;

    /**
     * @phpstan-var \Ekati\Structure\Stack<int>
     * @var \Ekati\Structure\Stack
     */
    private $stack;

    protected function setUp(): void
    {
        $this->stack = new Stack(self::CAPACITY);
    }

    public function testEmptyOnInitialization(): void
    {
        $this->assertTrue($this->stack->empty());
        $this->assertFalse($this->stack->full());
        $this->assertSame(0, $this->stack->size());
        $this->assertSame(self::CAPACITY, $this->stack->capacity());
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
    
    public function testPushThrowsExceptionOnFullStack(): void
    {
        $this->stack->push(1);
        $this->stack->push(2);
        
        $this->expectException(OverflowException::class);
        $this->stack->push(10);
    }

    public function testPushAndPop(): void
    {
        $this->stack->push(3);
        $this->assertSame(1, $this->stack->size());

        $this->stack->push(5);
        $this->assertSame(2, $this->stack->size());
        $this->assertTrue($this->stack->full());
        
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

    public function testStackWithUnlimitedCapacity(): void
    {
        $stack = new Stack();
        $stack->push(3);
        $this->assertSame(3, $stack->top());
        $this->assertSame(1, $stack->size());

        $stack->push(5);
        $this->assertSame(5, $stack->top());
        $this->assertSame(2, $stack->size());
        $this->assertFalse($stack->full());
        
        $this->assertSame(5, $stack->pop());
        $this->assertSame(1, $stack->size());
        $this->assertFalse($stack->empty());

        $this->assertSame(3, $stack->pop());
        $this->assertSame(0, $stack->size());
        $this->assertTrue($stack->empty());
    }
}
