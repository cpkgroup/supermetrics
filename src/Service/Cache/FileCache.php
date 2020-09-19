<?php

namespace App\Service\Cache;

use App\Service\Logger\LoggerInterface;

class FileCache implements CacheInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * FileCache constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function get($key)
    {
        $file = $this->getFileName($key);
        if (is_file($file)) {
            $data = file_get_contents($file);
            $cacheData = json_decode($data, true);

            if (isset($cacheData['lifeTime']) && $cacheData['lifeTime'] > time()) {
                $this->logger->info('[CACHE][GET] Key: ' . $key);
                return $cacheData['data'];
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function set($key, $data): void
    {
        $file = $this->getFileName($key);
        $cacheData = [
            'lifeTime' => time() + getenv('CACHE_LIFETIME'),
            'data' => $data
        ];
        if (file_put_contents($file, json_encode($cacheData))) {
            $this->logger->info('[CACHE][SET] Key: ' . $key);
        } else {
            $this->logger->error('[CACHE][SET] Failed, Key: ' . $key);
        }
    }

    /**
     * @param string $key
     * @return string
     */
    private function getFileName($key)
    {
        return getenv('ROOT_PATH') . 'var/cache/' . $key . '.txt';
    }
}
