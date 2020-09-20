<?php

namespace App\Service\Cache;

use App\Service\File\FileUpdaterTrait;
use App\Service\Logger\LoggerInterface;

/**
 * Caching data using files.
 */
class FileCache implements CacheInterface
{
    use FileUpdaterTrait;

    private LoggerInterface $logger;

    /**
     * FileCache constructor.
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        $filePath = $this->getFilePath($key);
        if ($this->isExist($filePath)) {
            $data = $this->getFileContents($filePath);
            $cacheData = json_decode($data, true);

            if (isset($cacheData['lifeTime']) && $cacheData['lifeTime'] > time()) {
                $this->logger->info('[CACHE][GET] Key: '.$key);

                return $cacheData['data'];
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $data): void
    {
        $cacheData = [
            'lifeTime' => time() + getenv('CACHE_LIFETIME'),
            'data' => $data,
        ];
        if ($this->putFileContents($this->getFilePath($key), json_encode($cacheData))) {
            $this->logger->info('[CACHE][SET] Key: '.$key);
        } else {
            $this->logger->error('[CACHE][SET] Failed, Key: '.$key);
        }
    }

    /**
     * @param string $key
     *
     * @return string
     */
    private function getFilePath($key)
    {
        return getenv('ROOT_PATH').'var/cache/'.$key.'.txt';
    }
}
