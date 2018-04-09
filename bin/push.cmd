@echo off

SET mypath=%~dp0

cd "%mypath:~0,-1%/.."

set ssh_remote=agate
set prod_dir=/var/www/www.studio-agate.com/www

@echo on

git push origin master ^
 && ssh %ssh_remote% git -C %prod_dir% pull origin master ^
 && ssh %ssh_remote% %prod_dir%/bin/deploy.bash
