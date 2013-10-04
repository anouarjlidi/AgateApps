<?php $time = microtime(true);$temp_time = $time;

echo 'Conversion Corahn-Rin'.PHP_EOL;
ini_set('cli_server.color', true);
ini_set('cli_server.color', 1);
$colors = new Colors();
showtime($temp_time, 'Conversion des tables de l\'ancienne vers la nouvelle version');

$total_times = array();
$total_msgs = array();

class Database extends PDO{public static $prefix;public $table='';private $c;private $d;private $f;private $g;private $h;private $i;private $j;private $l;private $m=false;private $n;private $o;function __construct($p='127.0.0.1',$q='root',$r='',$s='mydb',$u='',$w='mysql'){if(isset($this->table)){$this->table=$this->table;}$y[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;self::$prefix=$u;$z=$w.':host='.$p.';dbname='.$s.'';$this->initErr(true);try{parent::__construct($z,$q,$r,$y);$this->dbname=$s;}catch(Exception $d){return $this->showErr($d,null,null,true);}$this->noRes('SET NAMES "utf8"');}protected function initErr($aa=false,$bb='fatal'){$this->show_err=$aa==true?true:false;if($bb==='warning'){$this->err_type=E_USER_WARNING;}elseif($bb==='fatal'){$this->err_type=E_USER_ERROR;}elseif($bb==='notice'){$this->err_type=E_USER_NOTICE;}else{$this->err_type=E_USER_WARNING;}}protected function showErr($d=null,$cc=null,$dd=null,$ee=false){$ff=is_object($d)?$d->getTrace():'';echo 'Une erreur MySQL est survenue...<br />'.PHP_EOL;pr(array('pdo_ex'=>(is_object($d)?$d->getMessage():''),'qry'=>$cc,'trace'=>$ff));exit('ERREUR');}public static function sbuildReq($cc,$gg=array(),$table='my_table'){$gg=(array) $gg;if(strpos($cc,'%%%fields')!==false){$hh=array();foreach($gg as $ii=>$jj){$ii=str_replace(':','',$ii);$hh[]='%'.$ii.' = :'.$ii;}$cc=str_replace('%%%fields',implode(', ',$hh),$cc);}if(strpos($cc,'%%%in')!==false){if(empty($gg)){$cc=str_replace('%%%in','0',$cc);}else{$kk=implode(', ',array_fill(0,count($gg),'?'));$cc=str_replace('%%%in',$kk,$cc);}}$cc=preg_replace('#%%([a-zA-Z0-9_]+)#',' `'.self::$prefix.'$1` ',$cc);$cc=preg_replace('#%([a-zA-Z0-9_]+)#',' `$1` ',$cc);$ll=array();foreach($gg as $mm=>$nn){if(!preg_match('#^:#isUu',$mm)&&!is_numeric($mm)){unset($gg[$mm]);$gg[':'.$mm]=$nn;}}$cc=str_replace(PHP_EOL,' ',$cc);$cc=str_replace("\r",'',$cc);$cc=str_replace("\t",'',$cc);$cc=preg_replace('#\s\s+#Uu',' ',$cc);return $cc;}protected function last_id(){$oo=0;try{$oo=$this->lastInsertId();$oo=(int) $oo;}catch(Exception $d){$oo=$this->showErr($d,'',$oo,true);}return $oo;}public function req($cc,$gg=array()){$gg=(array) $gg;$cc=$this->buildReq($cc,$gg);$pp=$this->runReq($cc,$gg);if(is_object($pp)&&$pp->rowCount()>0){$qq=$pp->fetchAll(PDO::FETCH_ASSOC);foreach($qq as $rr=>$ss){foreach($ss as $tt=>$uu){if(is_numeric($uu)){$qq[$rr][$tt]=(int) $uu;}if(is_int($tt)){unset($qq[$rr][$tt]);}}}}elseif(is_array($pp)){$qq=$pp;}else{$qq=false;}$this->last_results=$qq;if(is_object($pp)){$pp->closeCursor();}return $qq;}public function row($cc,$gg=array()){$gg=(array) $gg;$cc=$this->buildReq($cc,$gg);if(!preg_match('#LIMIT +[0-9]+( *, *[0-9]+)?#isU',$cc)){$cc.=' LIMIT 0,1';}$pp=$this->runReq($cc,$gg);if(is_object($pp)&&$pp->rowCount()>0){$qq=$pp->fetch();foreach($qq as $rr=>$ss){if(is_numeric($ss)){$qq[$rr]=(int) $ss;}if(is_int($rr)){unset($qq[$rr]);}}}elseif(is_array($pp)){$qq=$pp;}else{$qq=false;}$this->last_results=$qq;if(is_object($pp)){$pp->closeCursor();}return $qq;}public function noRes($cc,$gg=array()){$gg=(array) $gg;$cc=$this->buildReq($cc,$gg);$pp=$this->runReq($cc,$gg);if(is_object($pp)&&$pp->rowCount()>0){$vv=$pp->rowCount();}elseif(is_array($pp)){$vv=$pp;}else{$vv=false;}$this->last_results=$vv;if($vv){$pp->closeCursor();}return $vv?true:false;}private function buildReq($cc,$gg=array()){if(strpos($cc,'[TABLE]')!==false){$cc=str_replace('%[TABLE]','[TABLE]',$cc);$cc=str_replace('[TABLE]','%'.$this->table,$cc);}$cc=$this->sbuildReq($cc,$gg,$this->table);$this->last_query=$cc;$this->last_values=$gg;return $cc;}private function runReq($cc,$gg=array()){$gg=(array) $gg;try{$pp=$this->prepare($cc);$pp->execute($gg);}catch(Exception $d){$pp=$this->showErr($d,$cc,$pp,true);}return $pp;}}
function showtime(&$temp_time,$b){
	global $total_times;
	global $colors;
	global $total_msgs;
	$temp_time=microtime(true)-$temp_time;
	$temp_time*=1000;
	$total_times[]=$temp_time;
	$b = trim($b, " \t\n\r\0\x0B");
	$str = "\t\n\r\0\x0B";
	$str = str_split($str);
	$b = str_replace($str, array_fill(0,5,''), $b);
	// print($colors->getColoredString(number_format($temp_time, 4, ',', ' ')."\t\t".$b.PHP_EOL, "blue") . PHP_EOL);
	echo "\t[".number_format($temp_time, 4, ',', ' ')."]\t\t".$b.PHP_EOL;
	$temp_time=microtime(true);
}

define('P_DUMP_INTCOLOR','blue');define('P_DUMP_FLOATCOLOR','darkblue');define('P_DUMP_NUMSTRINGCOLOR','#c0c');define('P_DUMP_STRINGCOLOR','darkgreen');define('P_DUMP_RESSCOLOR','#aa0');define('P_DUMP_NULLCOLOR','#aaa');define('P_DUMP_BOOLTRUECOLOR','#0c0');define('P_DUMP_BOOLFALSECOLOR','red');define('P_DUMP_OBJECTCOLOR','auto');define('P_DUMP_PADDINGLEFT','25px');define('P_DUMP_WIDTH','');function pr($a,$b=false){if($b===true){return print_r($a);}else{echo print_r($a);}}function pDumpTxt($a=null){$d='';if(is_int($a)){$d.='<small><em>entier</em></small> <span style="color:'.P_DUMP_INTCOLOR.';">'.$a.'</span>';}elseif(is_float($a)){$d.='<small><em>décimal</em></small> <span style="color:'.P_DUMP_FLOATCOLOR.';">'.$a.'</span>';}elseif(is_numeric($a)){$d.='<small><em>chaîne numÃ©rique</em> ('.strlen($a).')</small> <span style="color:'.P_DUMP_NUMSTRINGCOLOR.';">\''.$a.'\'</span>';}elseif(is_string($a)){$d.='<small><em>chaîne</em> ('.strlen($a).')</small> <span style="color:'.P_DUMP_STRINGCOLOR.';">\''.htmlspecialchars($a).'\'</span>';}elseif(is_resource($a)){$d.='<small><em>ressource</em></small> <span style="color:'.P_DUMP_RESSCOLOR.';">'.get_resource_type($a).'</span>';}elseif(is_null($a)){$d.='<span style="color: '.P_DUMP_NULLCOLOR.';">null</span>';}elseif(is_bool($a)){$d.='<span style="color: '.($a===true?P_DUMP_BOOLTRUECOLOR:P_DUMP_BOOLFALSECOLOR).';">'.($a===true?'true':'false').'</span>';}elseif(is_object($a)){$d.='<div style="color:'.P_DUMP_OBJECTCOLOR.';"><small>';ob_start();var_dump($a);$e=ob_get_clean();$d.=$e.'</small></div>';}elseif(is_array($a)){$d.='<em>tableau</em> {'.p_dump($a).'}';}else{$d.=$a;}return $d;}function p_dump($f){$d='<div class="p_dump" style="height:auto;min-height:0;margin: 0 auto;'.(P_DUMP_WIDTH?'max-width: '.P_DUMP_WIDTH.';':'').' min-height: 20px;">';$d.='<pre style="height:auto;min-height:0;">';if(!is_array($f)){$d.='<div style="margin-left: 0;">';$d.=pDumpTxt($f);$d.='</div>';}else{$d.='<div style="height:auto;min-height:0;padding-left: '.P_DUMP_PADDINGLEFT.';">';foreach($f as $g=>$a){$d.='<div style="height:auto;min-height:0;">';if(is_int($g)){$d.='<span style="color:'.P_DUMP_INTCOLOR.';">'.$g.'</span>';}else{$d.='<span style="color:'.P_DUMP_STRINGCOLOR.';">\''.$g.'\'</span>';}$d.=' => ';$d.=pDumpTxt($a);$d.='</div>';}$d.='</div>';}$d.='</pre></div>';return $d;}
function remove_comments(&$a){$b=explode(PHP_EOL,$a);$a="";$c=count($b);$d=false;for($e=0;$e<$c;$e++){if(preg_match("/^\/\*/",preg_quote($b[$e]))){$d=true;}if(!$d){$a.=$b[$e].PHP_EOL;}if(preg_match("/\*\/$/",preg_quote($b[$e]))){$d=false;}}unset($b);return $a;}
function remove_remarks($f){$b=explode(PHP_EOL,$f);$f="";$c=count($b);$a="";for($e=0;$e<$c;$e++){if(($e!=($c-1))||(strlen($b[$e])>0)){if(isset($b[$e][0])&&$b[$e][0]!="#"){$a.=$b[$e].PHP_EOL;}else{$a.=PHP_EOL;}$b[$e]="";}}return $a;}
function split_sql_file($f,$g){$h=explode($g,$f);$f="";$a=array();$k=array();$l=count($h);for($e=0;$e<$l;$e++){if(($e!=($l-1))||(strlen($h[$e]>0))){$m=preg_match_all("/'/",$h[$e],$k);$n=preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",$h[$e],$k);$o=$m-$n;if(($o%2)==0){$a[]=$h[$e];$h[$e]="";}else{$p=$h[$e].$g;$h[$e]="";$q=false;for($r=$e+1;(!$q&&($r<$l));$r++){$m=preg_match_all("/'/",$h[$r],$k);$n=preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",$h[$r],$k);$o=$m-$n;if(($o%2)==1){$a[]=$p.$h[$r];$h[$r]="";$p="";$q=true;$e=$r;}else{$p.=$h[$r].$g;$h[$r]="";}}}}}return $a;}
function get_query_from_file($a){$b=@fread(@fopen($a,'r'),@filesize($a))or die('problem ');$b=remove_remarks($b);$b=split_sql_file($b,';');$b=array_map('trim',$b);return $b;}
function table_dates($a){global $new;global $temp_time;if(!$new->req('SHOW COLUMNS FROM %'.$a.' LIKE "created"')){$new->noRes('ALTER TABLE %'.$a.' ADD `created` INT UNSIGNED NOT NULL');showtime($temp_time,'Added `'.$a.'` created column');}if(!$new->req('SHOW COLUMNS FROM %'.$a.' LIKE "updated"')){$new->noRes('ALTER TABLE %'.$a.' ADD `updated` INT UNSIGNED NOT NULL');showtime($temp_time,'Added `'.$a.'` updated column');}}

class Colors{private $a=array();private $b=array();public function __construct(){$this->a['black']='0;30';$this->a['dark_gray']='1;30';$this->a['blue']='0;34';$this->a['light_blue']='1;34';$this->a['green']='0;32';$this->a['light_green']='1;32';$this->a['cyan']='0;36';$this->a['light_cyan']='1;36';$this->a['red']='0;31';$this->a['light_red']='1;31';$this->a['purple']='0;35';$this->a['light_purple']='1;35';$this->a['brown']='0;33';$this->a['yellow']='1;33';$this->a['light_gray']='0;37';$this->a['white']='1;37';$this->b['black']='40';$this->b['red']='41';$this->b['green']='42';$this->b['yellow']='43';$this->b['blue']='44';$this->b['magenta']='45';$this->b['cyan']='46';$this->b['light_gray']='47';}public function getColoredString($d,$e=null,$f=null){return $d;$g="";if(isset($this->a[$e])){$g.="\033[".$this->a[$e]."m";}if(isset($this->b[$f])){$g.="\033[".$this->b[$f]."m";}$g.=$d."\033[0m";return $g;}public function getForegroundColors(){return array_keys($this->a);}public function getBackgroundColors(){return array_keys($this->b);}}
 
showtime($temp_time, 'Fin chargement des classes et fonctions');

$new = new Database('127.0.0.1', 'root', '', 'corahn_rin');
$old = new Database('127.0.0.1', 'root', '', 'esteren', 'est_');

showtime($temp_time, 'Initialisation de l\'ancienne et de la nouvelle base de données');

$dt = new DateTime();
$o = new ReflectionObject($dt);
$p = $o->getProperty('date');
$date = $p->getValue($dt);
$datetime = (object) array('date'=>$date);

$nbreq = 0;


/****************************/
/****************************/
/** RESAUVEGARDE DE LA BDD **/
/****************************/
/****************************/
// $newreq = get_query_from_file('new.sql');
// foreach ($newreq as $v) { $new->noRes($v); $nbreq++; }
/****************************/
/****************************/
/****************************/
/****************************/



// $new->noRes(file_get_contents('new.sql'));
showtime($temp_time, 'Suppression et réinsertion de la nouvelle base de données : '.$nbreq.' requêtes effectuées (approximation !)');
// foreach ($oldreq as $v) { $old->noRes($v); }
// $oldreq = get_query_from_file('old.sql');
// showtime($temp_time, 'Suppression et réinsertion de l\'ancienne base de données');
unset($oldreq, $newreq);

$tables = $old->req('SHOW TABLES');
$new_tables = $new->req('SHOW TABLES');
$tables_done = array();
$t=array();
foreach ($new_tables as $v){
	$ta=array_values($v);
	$t[]=$ta[0];
}
$new_tables=$t;
unset($t);
foreach ($tables as $v){$t=array_values($v);
$t=$t[0];
$t=str_replace('est_','',$t);
$$t=$old->req('SELECT * FROM %%'.$t);
}unset($t,$q,$v);


showtime($temp_time, 'Récupération de la structure des tables');

/*---------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
----------------------------------------- START -----------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------*/
showtime($temp_time, 'Début de l\'import');


$table = 'weapons';
$nbreq++;
foreach ( $armes as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['arme_id'],
		'name' => $v['arme_name'],
		'dmg' => $v['arme_dmg'],
		'price' => $v['arme_prix'],
		'availability' => $v['arme_dispo'],
		'range' => $v['arme_range'],
		'contact' => (strpos($v['arme_domain'], '2') !== false ? 1 : 0),
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($armes).' requêtes pour la table "'.$table.'"');




$table = 'armors';
$nbreq++;
foreach ( $armures as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['armure_id'],
		'name' => $v['armure_name'],
		'description' => $v['armure_desc'],
		'protection' => $v['armure_prot'],
		'price' => $v['armure_prix'],
		'availability' => $v['armure_dispo'],
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($armures).' requêtes pour la table "'.$table.'"');





$table = 'ways';
$nbreq++;
$voies_id = array();
$voies_short = array();
foreach ( $voies as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['voie_id'],
		'name' => $v['voie_name'],
		'short_name' => $v['voie_shortname'],
		'description' => $v['voie_desc'],
		'fault' => $v['voie_travers'],
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	$voies_id[$v['voie_id']] = $v;
	$voies_short[$v['voie_shortname']] = $v;
}$tables_done[]=$table;showtime($temp_time, count($voies).' requêtes pour la table "'.$table.'"');




TODO : RENAME TABLE `desordes` TO `disorders`
$table = 'disorders';
$nbreq++;
foreach ( $desordres as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['desordre_id'],
		'name' => $v['desordre_name'],
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($desordres).' requêtes pour la table "'.$table.'"');





$table = 'traits';
$nbreq++;
foreach ( $traitscaractere as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['trait_id'],
		'id_ways' => $voies_short[$v['trait_voie']]['voie_id'],
		'name' => $v['trait_name'],
		'name_female' => $v['trait_name_female'],
		'is_quality' => ($v['trait_qd'] === 'q' ? 1 : 0),
		'is_major' => ($v['trait_mm'] === 'maj' ? 1 : 0),
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($traitscaractere).' requêtes pour la table "'.$table.'"');




$table = 'avdesv';
$nbreq++;
foreach ( $avdesv as $v) {
	$nbreq++;
	$datas = array(
		'id' => $v['avdesv_id'],
		'name' => $v['avdesv_name'],
		'xp' => $v['avdesv_xp'],
		'description' => $v['avdesv_desc'],
		'name_female' => $v['avdesv_name_female'],
		'bonusdisc' => $v['avdesv_bonusdisc'],
		'is_desv' => (strpos($v['avdesv_type'], 'desv') !== false ? 1 : 0),
		'is_combat_art' => (strpos($v['avdesv_name'], 'de combat') !== false ? 1 : 0),
		'can_be_doubled' => ($v['avdesv_double'] ? 1 : 0),
		'created' => $datetime->date,
		'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($avdesv).' requêtes pour la table "'.$table.'"');







$table = 'books';
$nbreq++;
$sql = 'INSERT INTO `books` SET `id` = :id, `name` = :name, `description` = :description, `created` = :created, `updated` = :updated';
$q = $new->prepare($sql);
$nbreq+=8;
$q->execute(array('id' => 1,'name' => 'Livre 0 - Prologue',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 2,'name' => 'Livre 1 - Univers',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 3,'name' => 'Livre 2 - Voyages',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 4,'name' => 'Livre 2 - Voyages (Réédition)',	'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 5,'name' => 'Livre 3 - Dearg',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 6,'name' => 'Livre 4 - Secrets',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 7,'name' => 'Le Monastère de Tuath',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
$q->execute(array('id' => 8,'name' => 'Contenu de la communauté',		'description' => 'Ce contenu est par définition non-officiel.','created' => $datetime->date,'updated' => $datetime->date,));
$tables_done[]=$table;showtime($temp_time, '8 requêtes pour la table "'.$table.'"');






$table = 'domains';
$nbreq++;
foreach ( $domains as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['domain_id'],
			'name' => $v['domain_name'],
			'description' => $v['domain_desc'],
			'id_ways' => $v['voie_id'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($domains).' requêtes pour la table "'.$table.'"');







$table = 'disciplines';
$nbreq++;
foreach ( $disciplines as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['disc_id'],
			'name' => $v['disc_name'],
			'description' => '',
			'rank' => $v['disc_rang'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($disciplines).' requêtes pour la table "'.$table.'"');



$table = 'discipline_domains';
$nbreq++;
foreach ( $discdoms as $v) {
	$nbreq++;
	$datas = array(
		'id_disciplines' => $v['disc_id'],
		'id_domains' => $v['domain_id'],
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($discdoms).' requêtes pour la table "'.$table.'"');






$table = 'flux';
$nbreq++;
$sql = 'INSERT INTO `flux` SET `id` = :id, `name` = :name, `created` = :created, `updated` = :updated';
$q = $new->prepare($sql);
$nbreq+=5;
$q->execute(array('id' => 1,'name' => 'Végétal',	'created' => $datetime->date, 'updated' => $datetime->date,));
$q->execute(array('id' => 2,'name' => 'Minéral',	'created' => $datetime->date, 'updated' => $datetime->date,));
$q->execute(array('id' => 3,'name' => 'Organique',	'created' => $datetime->date, 'updated' => $datetime->date,));
$q->execute(array('id' => 4,'name' => 'Fossile',	'created' => $datetime->date, 'updated' => $datetime->date,));
$q->execute(array('id' => 5,'name' => 'M',			'created' => $datetime->date, 'updated' => $datetime->date,));
$tables_done[]=$table;showtime($temp_time, '5 requêtes pour la table "'.$table.'"');




$table = 'games';
$nbreq++;
foreach ( $games as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['game_id'],
			'name' => $v['game_name'],
			'summary' => $v['game_summary'],
			'gm_notes' => $v['game_notes'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($games).' requêtes pour la table "'.$table.'"');









$table = 'steps';
$nbreq++;
foreach ( $steps as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['gen_id'],
			'step' => $v['gen_step'],
			'slug' => str_replace('_','-', $v['gen_mod']),
			'title' => $v['gen_anchor'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($steps).' requêtes pour la table "'.$table.'"');


















$table = 'jobs';
$nbreq++;
foreach ( $jobs as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['job_id'],
			'id_books' => ($v['job_book'] ? 1 : 8),
			'name' => $v['job_name'],
			'description' => $v['job_desc'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($jobs).' requêtes pour la table "'.$table.'"');











$table = 'mails';
$nbreq++;
foreach ( $mails as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['mail_id'],
			'code' => $v['mail_code'],
			'content' => $v['mail_contents'],
			'subject' => $v['mail_subject'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($mails).' requêtes pour la table "'.$table.'"');


$table = 'mails_sent';
$nbreq++;
foreach ( $mails_sent as $v) {
	$nbreq++;
	$dest = json_decode($v['mail_dest'], true);
	$datas = array(
			'id' => $v['mail_sent_id'],
			'to_name' => (isset($dest['name']) ? $dest['name'] : ''),
			'to_email' => (isset($dest['mail']) ? $dest['mail'] : ''),
			'id_mails' => $v['mail_id'],
			'content' => $v['mail_content'],
			'subject' => $v['mail_subj'],
			'date' => $v['mail_date'],
			'created' => $v['mail_date'],
			'updated' => $v['mail_date'],
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($mails_sent).' requêtes pour la table "'.$table.'"');













$table = 'regions';
$nbreq++;
foreach ( $regions as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['region_id'],
			'name' => $v['region_name'],
			'description' => $v['region_desc'],
			'kingdom' => $v['region_kingdom'],
			'coords' => $v['region_htmlmap'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($regions).' requêtes pour la table "'.$table.'"');











$table = 'setbacks';
foreach ( $revers as $v) {
	$nbreq++;
	$datas = array(
			'id' => $v['rev_id'],
			'name' => $v['rev_name'],
			'description' => $v['rev_desc'],
			// 'malus' => $v['rev_malus'],//TODO => RAJOUTER MALUS DANS L'ENTITE !!!!
			'created' => $datetime->date,
			'updated' => $datetime->date,
	);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
}$tables_done[]=$table;showtime($temp_time, count($revers).' requêtes pour la table "'.$table.'"');








/****************************************************
*****************************************************
*******************FIN DE L'IMPORT*******************
*****************************************************
*****************************************************/
// showtime($temp_time, 'Fin de l\'import, <strong style="color: #88f;">'.$nbreq.'</strong> insertions effectuées');
showtime($temp_time, 'Fin de l\'import, '.$colors->getColoredString($nbreq, "green").' insertions effectuées');

$max = (microtime(true) - $time);
$max = max($total_times);
foreach ($total_msgs as $k => $msg) {
	$t = $total_times[$k];
	$ratio = $t > 0 ? (($t / $max)*750) : 0;
	$ratio *= 1750;
	$color = '#ff0';
	if ($ratio < 0.1) { $ratio = 0; }
	if ($ratio < 25) { $color = '#0a0'; }
	if ($ratio > 50) { $color = '#f70'; }
	if ($ratio > 80) { $color = '#f00'; }
	if ($ratio > 152) { $color = '#f00'; $ratio = 152; }
	// $bar = '<span style="margin-right: 10px; display: inline-block;height: 12px;width:152px;border:solid 1px #777"
		// ><span style="display:inline-block; max-width: 100%; height: 10px;width: '.$ratio.'px;background:'.$color.';"
	// ></span></span>';
	$bar = '';
	for ($i = 0; $i <= $ratio; $i += 10) { $bar .= '|'; }
	echo $bar;
	echo $msg;
}




/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! TABLES À REFAIRE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!! Toutes les tables d'asso où un champ manque !!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
$tables_err = array();
$tables_done[] = 'char_disciplines'; $tables_err[] = 'char_disciplines';
$tables_done[] = 'char_domains'; $tables_err[] = 'char_domains';
$tables_done[] = 'char_ways'; $tables_err[] = 'char_ways';
$tables_done[] = 'char_flux'; $tables_err[] = 'char_flux';
$tables_done[] = 'char_avtgs'; $tables_err[] = 'char_avtgs';
$tables_done[] = 'char_revers'; $tables_err[] = 'char_revers';
$tables_done[] = 'disorder_ways'; $tables_err[] = 'disorder_ways';
$tables_done[] = 'game_players'; $tables_err[] = 'game_players';
/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/






/*---------------------------------------------------------------------------------------
 -----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
---------------------------- TABLES À NE PAS FAIRE CAR VIDES ----------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------*/
$tables_done[] = 'artifacts';
$tables_done[] = 'ogham';
$tables_done[] = 'miracles';
$tables_done[] = 'pages';	//Le CMS ne contient rien au départ, et sera créé plus tard
$tables_done[] = 'users';	//IMPORTANT => Sera fait directement avec FOSUserBundle en ligne de commmande
$tables_done[] = 'groups';	//IMPORTANT => Sera fait directement avec FOSUserBundle en ligne de commmande


echo 'Tables à terminer :'.PHP_EOL;
foreach ($new_tables as $t) {
	if (!in_array($t, $tables_done)) {
		echo "\t", $colors->getColoredString($t, "green");
	}
}

echo 'Tables à refaire :'.PHP_EOL;
foreach ($tables_err as $t) {
	echo "\t", $colors->getColoredString($t, "red");
}

showtime($temp_time, 'Finalisation');

echo PHP_EOL.'Temps d\'exécution : '.(microtime(true) - $time).' secondes';
echo PHP_EOL;