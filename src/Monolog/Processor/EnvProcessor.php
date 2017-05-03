<?php

namespace Monolog\Processor;

use Monolog\Logger;

class EnvProcessor
{
    public function __invoke(array $record)
    {
        $record['extra']['os_info'] = php_uname();
        $record['extra']['php_version'] = phpversion();
        $record['extra']['zend_version'] = zend_version();

        return $record;
    }
}
