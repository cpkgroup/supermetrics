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
        $fileName = getenv('ROOT_PATH') . 'var/log/' . date('Ymd') . '.txt';
        $this->fileHandler = fopen($fileName, 'a');
    }

    /**
     * @inheritDoc
     */
    public function error($message, array $context = array())
    {
        $this->log('ERROR', $message, $context);
    }

    /**
     * @inheritDoc
     */
    public function info($message, array $context = array())
    {
        $this->log('INFO', $message, $context);
    }

    /**
     * @param $type
     * @param $message
     * @param array $context
     */
    private function log($type, $message, array $context = array())
    {
        $data = '[' . date('Y-m-d H:i:s') . '] ' . $type . ': ' . $message . ' ' . json_encode($context) . "\n";
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
