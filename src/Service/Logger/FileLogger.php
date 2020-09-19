<?php

namespace App\Service\Logger;

class FileLogger implements LoggerInterface
{
    /**
     * @var false|resource
     */
    private $fileHandler;

    /**
     * FileLogger constructor.
     */
    public function __construct()
    {
        $fileName = getenv('ROOT_PATH').'var/log/'.date('Ymd').'.txt';
        $this->fileHandler = fopen($fileName, 'a');
    }

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

    /**
     * @param $type
     * @param $message
     */
    private function log($type, $message, array $context = [])
    {
        $data = '['.date('Y-m-d H:i:s').'] '.$type.': '.$message.' '.json_encode($context)."\n";
        fwrite($this->fileHandler, $data);
    }

    /**
     * FileLogger destruct.
     */
    public function __destruct()
    {
        fclose($this->fileHandler);
    }
}
