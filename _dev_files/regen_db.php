<?php
$time = microtime(true)*1000;
$console_dir = '..'.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'console';
$cmd = array();
$cmd[] = 'php '.$console_dir.' cache:clear --no-warmup';
$cmd[] = 'php '.$console_dir.' doctrine:database:drop --force';
$cmd[] = 'php '.$console_dir.' doctrine:database:create';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinCharactersBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities EsterenMapsBundle --no-backup';
//$cmd[] = 'php '.$console_dir.' doctrine:generate:entities EsterenPagesBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:generate:entities CorahnRinUsersBundle --no-backup';
$cmd[] = 'php '.$console_dir.' doctrine:schema:update --force';
$cmd[] = 'php '.$console_dir.' cache:warmup';

foreach ($cmd as $c) {
	echo "-----------------------------------------\n",
		"-----------------------------------------\n",
		"\t [".(microtime(true)*1000 - $time)."] $ ".$c."\n";
	$time = microtime(true)*1000;
	system($c);
}