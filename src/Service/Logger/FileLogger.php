<?php

namespace App\Service\Logger;

use App\Service\File\FileUpdaterTrait;

class FileLogger implements LoggerInterface
{
    use FileUpdaterTrait;

    /**
     * {@inheritdoc}
     */
    public function error($message, array $context = [])
    {
        $this->log('ERROR', $message, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function info($message, array $context = [])
    {
        $this->log('INFO', $message, $context);
    }

    private function log(string $type, string $message, array $context = [])
    {
        $data = '['.date('Y-m-d H:i:s').'] '.$type.': '.$message.' '.json_encode($context)."\n";
        $this->writeInFile($this->getFilePath(), $data);
    }

    /**
     * @return string
     */
    private function getFilePath()
    {
        return getenv('ROOT_PATH').'var/log/'.date('Ymd').'.txt';
    }
}
