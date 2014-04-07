<?php

/**
 * File assets
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 27/00/2014
 */


echo
'   ______                     __                   ____   _      ',"\n",
'  / ____/____   _____ ____ _ / /_   ____          / __ \\ (_)____ ',"\n",
' / /    / __ \\ / ___// __ `// __ \\ / __ \\ ______ / /_/ // // __ \\',"\n",
'/ /___ / /_/ // /   / /_/ // / / // / / //_____// _, _// // / / /',"\n",
'\\____/ \\____//_/    \\__,_//_/ /_//_/ /_/       /_/ |_|/_//_/ /_/ ',"\n\n";

echo 'Installing assets for Corahn-Rin'."\n\n";

ini_set('cli_server.color', true);
ini_set('cli_server.color', 1);

define('CONSOLE', 'php "'.preg_replace('#_dev_files/?#isUu', '', str_replace('\\','/', __DIR__)).'app/console" ');

$commands_list = array(
    'assets:install',
    'assetic:dump --env=dev_fast'
);

foreach ($commands_list as $command) {
    echo 'Executing command '.$command."\n";
    system(CONSOLE.$command);
    echo "\n";
}
