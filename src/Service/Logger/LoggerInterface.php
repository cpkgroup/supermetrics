<?php

namespace App\Service\Logger;

interface LoggerInterface
{
    /**
     * Runtime errors.
     *
     * @param string $message
     *
     * @return void
     */
    public function error($message, array $context = []);

    /**
     * Interesting events.
     *
     * @param string $message
     *
     * @return void
     */
    public function info($message, array $context = []);
}
