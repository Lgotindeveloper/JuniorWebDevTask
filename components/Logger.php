<?php


class Logger
{
    public function log($message)
    {
        $h = fopen('log', 'a');
        fwrite($h, $message . "\n");
        fclose($h);
    }
}