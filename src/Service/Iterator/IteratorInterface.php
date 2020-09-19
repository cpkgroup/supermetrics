<?php

namespace App\Service\Iterator;

use Countable;
use Iterator;

/**
 * Interface IteratorInterface.
 */
interface IteratorInterface extends Iterator, Countable
{
    public function push(array $data): void;
}
