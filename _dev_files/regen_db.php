<?php
$time = microtime(true)*1000;
$console_dir = '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'console';
$cmd = array();
$cmd[] = 'php '.$console_dir.' cache:clear --no-warmup';
$cmd[] = 'php '.$console_dir.' doctrine:database:drop --force';
$cmd[] = 'php '.$console_dir.' doctrine:database:create';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinCharactersBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinMapsBundle --no-backup';
//$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinPagesBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinUsersBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:schema:update --force';

foreach ($cmd as $c) {
	echo "-----------------------------------------\n",
		"-----------------------------------------\n",
		"\t [".(microtime(true)*1000 - $time)."] $ ".$c."\n";
	$time = microtime(true)*1000;
	system($c);
}