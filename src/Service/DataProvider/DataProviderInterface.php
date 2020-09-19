<?php

namespace App\Service\DataProvider;

use App\Service\Iterator\IteratorInterface;

interface DataProviderInterface
{
    /**
     * @return IteratorInterface
     */
    public function prepareData();
}
