<?php

namespace App\Service\Cache;

interface CacheInterface
{
    /**
     * @param string $key
     *
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param array  $data
     */
    public function set($key, $data);
}
