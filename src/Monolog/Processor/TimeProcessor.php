<?php

namespace Monolog\Processor;

use Monolog\Logger;

class TimeProcessor
{
    private $startTime = 0;
    private $totalTime = 0;

    public function __invoke(array $record)
    {
        $record['extra']['micro_time'] = $this->getMicroTime();
        $record['extra']['exec_time'] = $this->getExecTime();
        $record['extra']['total_time'] = $this->totalTime;
//        $record['extra']['timezone'] = date_default_timezone_get();

        return $record;
    }

    private function getMicroTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    private function getExecTime()
    {
        $currentTime = $this->getMicroTime();

        if (empty($this->startTime)) {
            $this->startTime = $currentTime;
            $execTime = 0;
        } else {
            $execTime = bcsub($currentTime, $this->startTime, 4);
            $this->totalTime = bcadd($this->totalTime, $execTime, 4);
            $this->startTime = $currentTime;
        }

        return $execTime;
    }
}
