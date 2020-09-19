<?php

namespace App\Service\Iterator;

/**
 * Class ArrayIterator.
 */
class ArrayIterator implements IteratorInterface
{
    /**
     * @var array
     */
    private array $items;

    /**
     * @var string
     */
    private ?string $className;

    /**
     * @var int
     */
    private int $idx = 0;

    /**
     * ArrayIterator constructor.
     * @param string|null $className
     */
    public function __construct(string $className = null)
    {
        $this->items = [];
        $this->className = $className;
    }

    /**
     * @param array $data
     * @return void
     */
    public function push(array $data): void
    {
        if ($this->className) {
            $data = new $this->className($data);
        }
        $this->items[] = $data;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        $this->idx = 0;
    }

    /**
     * @return array|false
     */
    public function current()
    {
        return $this->items[$this->idx];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->idx;
    }

    /**
     * @return void
     */
    public function next(): void
    {
        ++$this->idx;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return $this->idx >= 0 && $this->idx < $this->count();
    }
}
