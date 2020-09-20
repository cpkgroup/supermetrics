<?php

namespace App\Tests\Service\Iterator;

use App\Entity\Post;
use App\Service\Iterator\ArrayIterator;
use DateTime;
use PHPUnit\Framework\TestCase;

class ArrayIteratorTest extends TestCase
{
    protected array $items;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->items = [
            [
                'Id' => '123',
                'fromName' => 'Alex',
                'fromId' => '54',
                'message' => 'sdgsgsg',
                'type' => 'test',
                'createdTime' => '2020-09-18T09:12:20+00:00',
            ],
            [
                'Id' => '1',
                'fromName' => 'Luis',
                'fromId' => '34',
                'message' => 'asdsad asd sadsadasas',
                'type' => 'test',
                'createdTime' => '2020-09-10 20:20:30',
            ],
            [
                'Id' => '5',
                'fromName' => 'Mohamad',
                'fromId' => '44',
                'message' => 'asdsadsa lk;;lsdkasl;d',
                'type' => 'test',
                'createdTime' => '2020-09-18 10:12',
            ],
        ];
    }

    public function testArrayIterator()
    {
        $iterator = new ArrayIterator();
        foreach ($this->items as $item) {
            $iterator->push($item);
        }

        foreach ($iterator as $index => $item) {
            self::assertIsArray($item);
            self::assertEquals($this->items[$index]['Id'], $item['Id']);
            self::assertEquals($this->items[$index]['fromName'], $item['fromName']);
            self::assertEquals($this->items[$index]['fromId'], $item['fromId']);
            self::assertEquals($this->items[$index]['message'], $item['message']);
            self::assertEquals($this->items[$index]['type'], $item['type']);
            self::assertEquals($this->items[$index]['createdTime'], $item['createdTime']);
        }
    }

    public function testArrayIteratorWithClassName()
    {
        $iterator = new ArrayIterator(Post::class);
        foreach ($this->items as $item) {
            $iterator->push($item);
        }

        foreach ($iterator as $index => $item) {
            self::assertInstanceOf(Post::class, $item);
            /* @var Post $item */
            self::assertEquals($this->items[$index]['Id'], $item->getId());
            self::assertEquals($this->items[$index]['fromName'], $item->getFromName());
            self::assertEquals($this->items[$index]['fromId'], $item->getFromId());
            self::assertEquals($this->items[$index]['message'], $item->getMessage());
            self::assertEquals($this->items[$index]['type'], $item->getType());
            self::assertInstanceOf(DateTime::class, $item->getCreatedTime());
            self::assertEquals(new DateTime($this->items[$index]['createdTime']), $item->getCreatedTime());
        }
    }
}
