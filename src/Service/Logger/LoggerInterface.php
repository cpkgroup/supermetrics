<?php

namespace App\Service\Logger;

interface LoggerInterface
{
    /**
     * Runtime errors.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function error($message, array $context = array());

    /**
     * Interesting events.
     *
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    public function info($message, array $context = array());
}
