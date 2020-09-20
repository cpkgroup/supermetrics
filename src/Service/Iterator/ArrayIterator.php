<?php

namespace App\Service\Iterator;

/**
 * Class ArrayIterator.
 */
class ArrayIterator implements IteratorInterface
{
    private array $items;

    private ?string $className;

    private int $idx = 0;

    /**
     * When className parameter sent, first create an object from class
     * then the current item will be pass as the constructor param to the class object.
     */
    public function __construct(string $className = null)
    {
        $this->items = [];
        $this->className = $className;
    }

    public function push(array $data): void
    {
        if ($this->className) {
            $data = new $this->className($data);
        }
        $this->items[] = $data;
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function rewind(): void
    {
        $this->idx = 0;
    }

    /**
     * @return object|array|false
     */
    public function current()
    {
        return $this->items[$this->idx];
    }

    public function key(): int
    {
        return $this->idx;
    }

    public function next(): void
    {
        ++$this->idx;
    }

    public function valid(): bool
    {
        return $this->idx >= 0 && $this->idx < $this->count();
    }
}
