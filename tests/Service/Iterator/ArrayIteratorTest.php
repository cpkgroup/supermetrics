<?php

namespace App\Tests\Service\Iterator;

use App\Service\Iterator\ArrayIterator;
use PHPUnit\Framework\TestCase;

class ArrayIteratorTest extends TestCase
{
    public function testArrayIterator()
    {
        $arrays = $this->getArrayData();
        $iterator = new ArrayIterator();

        foreach ($arrays as $array) {
            $iterator->push($array);
        }

        foreach ($iterator as $index => $item) {
            self::assertEquals($arrays[$index]['fromName'], $item['fromName']);
            self::assertEquals($arrays[$index]['Id'], $item['Id']);
        }
    }

    private function getArrayData()
    {
        return [
            ['fromName' => 'Alex', 'Id' => '123'],
            ['fromName' => 'Mohamad', 'Id' => '432'],
            ['fromName' => 'H', 'Id' => '666'],
        ];
    }
}
