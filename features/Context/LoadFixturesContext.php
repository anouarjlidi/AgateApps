<?php

namespace Context;


use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\Process\Process;

class LoadFixturesContext extends RawMinkContext
{
    public function resetDatabase()
    {
        $commands = [
            'php bin/console d:d:d --force',
            'php bin/console d:d:c',
            'php bin/console d:s:c',
            'php bin/console d:f:l --append',
        ];

        foreach ($commands as $command) {
            $process = new Process($command);
            $process->setTimeout(500);
            $process->run();
            if (!$process->isSuccessful()) {
                throw new \RuntimeException($process->getErrorOutput());
            }
        }
    }
}
