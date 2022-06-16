<?php

declare(strict_types=1);

namespace Tests\Structure;

use PHPUnit\Framework\TestCase;
use Ekati\Structure\Queue;
use Ekati\Exception\UnderflowException;
use Ekati\Exception\OverflowException;
use Ekati\Exception\EmptyContainerException;

/**
 * Tests for the Queue class
 *
 * @author Theodoros Papadopoulos
 */
class QueueTest extends TestCase
{
    private const CAPACITY = 2;

    /**
     * @phpstan-var Queue<int>
     * @var Queue
     */
    private $queue;

    protected function setUp(): void
    {
        $this->queue = new Queue(self::CAPACITY);
    }

    public function testEmptyOnInitialization(): void
    {
        $this->assertTrue($this->queue->empty());
        $this->assertFalse($this->queue->full());
        $this->assertSame(0, $this->queue->size());
        $this->assertSame(self::CAPACITY, $this->queue->capacity());
    }

    public function testFrontThrowsOnEmptyQueue(): void
    {
        $this->expectException(UnderflowException::class);
        $this->queue->front();
    }

    public function testBackThrowsOnEmptyQueue(): void
    {
        $this->expectException(UnderflowException::class);
        $this->queue->back();
    }

    public function testPopThrowsOnEmptyQueue(): void
    {
        $this->expectException(UnderflowException::class);
        $this->queue->pop();
    }

    public function testPushThrowsOnFullQueue(): void
    {
        $this->queue->push(1);
        $this->queue->push(2);
        $this->assertTrue($this->queue->full());
        
        $this->expectException(OverflowException::class);
        $this->queue->push(3);
    }

    public function testPushAndPopLinear(): void
    {
        // Linear push and pop
        $this->queue->push(1);
        $this->assertSame(1, $this->queue->size());
        $this->queue->push(2);
        $this->assertSame(2, $this->queue->size());

        $this->assertSame(1, $this->queue->pop());
        $this->assertSame(1, $this->queue->size());
        $this->assertSame(2, $this->queue->pop());
        $this->assertSame(0, $this->queue->size());
    }

    public function testPushAndPopCircular(): void
    {
        // Linear push and pop
        $this->queue->push(1);
        $this->queue->push(2);
        $this->assertTrue($this->queue->full());

        $this->assertSame(1, $this->queue->pop());
        $this->assertSame(1, $this->queue->size());
        $this->queue->push(3);
        $this->assertTrue($this->queue->full());

        $this->assertSame(2, $this->queue->pop());
        $this->assertSame(3, $this->queue->pop());
        $this->assertTrue($this->queue->empty());

        $this->queue->push(1);
        $this->queue->push(2);
        $this->assertTrue($this->queue->full());
    }

    public function testFrontAccess(): void
    {
        // Linear push and pop
        $this->queue->push(4);
        $this->assertSame(1, $this->queue->size());

        $this->assertSame(4, $this->queue->front());
        $this->assertSame(1, $this->queue->size());

        $this->queue->push(7);
        $this->assertSame(4, $this->queue->front());
        $this->assertSame(2, $this->queue->size());
        
        $this->queue->pop();
        $this->assertSame(7, $this->queue->front());
        $this->assertSame(1, $this->queue->size());
    }

    public function testBackAccess(): void
    {
        // Linear push and pop
        $this->queue->push(4);
        $this->assertSame(1, $this->queue->size());

        $this->assertSame(4, $this->queue->back());
        $this->assertSame(1, $this->queue->size());

        $this->queue->push(7);
        $this->assertSame(7, $this->queue->back());
        $this->assertSame(2, $this->queue->size());
        
        $this->queue->pop();
        $this->assertSame(7, $this->queue->back());
        $this->assertSame(1, $this->queue->size());
    }

    public function testQueueWithUnlimitedSize(): void
    {
        $queue = new Queue();
        $queue->push(1);
        $this->assertSame(1, $queue->front());
        $this->assertSame(1, $queue->back());
        
        $queue->push(2);
        $this->assertSame(1, $queue->front());
        $this->assertSame(2, $queue->back());
        $this->assertFalse($queue->full());

        $this->assertSame(1, $queue->pop());
        $this->assertSame(2, $queue->front());
        $this->assertSame(2, $queue->back());
        $this->assertSame(1, $queue->size());
        
        $queue->push(3);
        $this->assertSame(2, $queue->front());
        $this->assertSame(3, $queue->back());
        $this->assertSame(2, $queue->size());
        $this->assertFalse($queue->full());

        $this->assertSame(2, $queue->pop());
        $this->assertSame(3, $queue->pop());
        $this->assertTrue($queue->empty());

        $queue->push(1);
        $queue->push(2);
        $this->assertFalse($queue->full());
    }
}
