<?php

namespace App\Service\DataProvider;

use App\Service\Iterator\IteratorInterface;

interface DataProviderInterface
{
    /**
     * This method prepare data into the $itrator object by offset and limit.
     *
     * @return void
     */
    public function prepareData(IteratorInterface $itrator, int $offset, int $limit);
}
