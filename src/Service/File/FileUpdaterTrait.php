<?php

namespace App\Service\File;

trait FileUpdaterTrait
{
    /**
     * @var false|resource
     */
    private $fileHandle;

    /**
     * @param string $filePath
     *
     * @return bool
     */
    protected function isExist($filePath)
    {
        return is_file($filePath);
    }

    /**
     * @param string $filePath
     *
     * @return false|string
     */
    protected function getFileContents($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * @param $filePath
     * @param $data
     *
     * @return false|int
     */
    protected function putFileContents($filePath, $data)
    {
        return file_put_contents($filePath, $data);
    }

    /**
     * Write data at the end of file.
     *
     * @param string $filePath
     * @param string $data
     *
     * @return false|int
     */
    protected function writeInFile($filePath, $data)
    {
        if ($this->fileHandle) {
            $resourceMeta = stream_get_meta_data($this->fileHandle);
            if (!$resourceMeta || $resourceMeta['uri'] != $filePath) {
                $this->fileHandle = null;
            }
        }
        if (!$this->fileHandle) {
            $this->fileHandle = fopen($filePath, 'a');
        }

        return fwrite($this->fileHandle, $data);
    }

    /**
     * FileTrait destruct.
     */
    public function __destruct()
    {
        if ($this->fileHandle) {
            fclose($this->fileHandle);
        }
    }
}
