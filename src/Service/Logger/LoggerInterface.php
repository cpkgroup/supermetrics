<?php

namespace App\Service\Logger;

interface LoggerInterface
{
    /**
     * Runtime errors.
     *
     * @return void
     */
    public function error(string $message, array $context = []);

    /**
     * Interesting events.
     *
     * @return void
     */
    public function info(string $message, array $context = []);
}
