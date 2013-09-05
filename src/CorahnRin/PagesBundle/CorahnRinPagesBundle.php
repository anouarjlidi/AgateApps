<?php

namespace CorahnRin\PagesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use CorahnRinTools;

class CorahnRinPagesBundle extends Bundle
{
	function __construct(){
		new CorahnRinTools();
	}
	function __destruct() {
		//var_dump($this);
	}
}
