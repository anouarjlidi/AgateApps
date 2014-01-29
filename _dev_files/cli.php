<?php $time = microtime(true);$temp_time = $time;

echo 'Conversion Corahn-Rin'."\n";
$arglocal = isset($argv[1]) ? $argv[1] : 'local';
if ($arglocal === 'local') { exec('chcp 65001'); }
ini_set('cli_server.color', true);
ini_set('cli_server.color', 1);
$colors = new Colors();
showtime($temp_time, 'Conversion des tables de l\'ancienne vers la nouvelle version');

$total_times = array();
$total_msgs = array();

class Database extends PDO{public static $prefix;
public $table='';
private $c;
private $d;
private $f;
private $g;
private $h;
private $i;
private $j;
private $l;
private $m=false;
private $n;
private $o;
function __construct($p='127.0.0.1',$q='root',$r='',$s='mydb',$u='',$w='mysql'){if(isset($this->table)){$this->table=$this->table;
}$y[PDO::ATTR_ERRMODE]=PDO::ERRMODE_EXCEPTION;
self::$prefix=$u;
$z=$w.':host='.$p.';
dbname='.$s.'';
$this->initErr(true);
try{parent::__construct($z,$q,$r,$y);
$this->dbname=$s;
}catch(Exception $d){return $this->showErr($d,null,null,true);
}$this->noRes('SET NAMES "utf8"');
}protected function initErr($aa=false,$bb='fatal'){$this->show_err=$aa==true?true:false;
if($bb==='warning'){$this->err_type=E_USER_WARNING;
}elseif($bb==='fatal'){$this->err_type=E_USER_ERROR;
}elseif($bb==='notice'){$this->err_type=E_USER_NOTICE;
}else{$this->err_type=E_USER_WARNING;
}}protected function showErr($d=null,$cc=null,$dd=null,$ee=false){$ff=is_object($d)?$d->getTrace():'';
echo 'Une erreur MySQL est survenue...<br />'."\n";
pr(array('pdo_ex'=>(is_object($d)?$d->getMessage():''),'qry'=>$cc,'datas'=>$this->last_values/*,'trace'=>$ff*/));
exit("\n".'ERREUR'."\n");
}public static function sbuildReq($cc,$gg=array(),$table='my_table'){$gg=(array) $gg;
if(strpos($cc,'%%%fields')!==false){$hh=array();
foreach($gg as $ii=>$jj){$ii=str_replace(':','',$ii);
$hh[]='%'.$ii.' = :'.$ii;
}$cc=str_replace('%%%fields',implode(', ',$hh),$cc);
}if(strpos($cc,'%%%in')!==false){if(empty($gg)){$cc=str_replace('%%%in','0',$cc);
}else{$kk=implode(', ',array_fill(0,count($gg),'?'));
$cc=str_replace('%%%in',$kk,$cc);
}}$cc=preg_replace('#%%([a-zA-Z0-9_]+)#',' `'.self::$prefix.'$1` ',$cc);
$cc=preg_replace('#%([a-zA-Z0-9_]+)#',' `$1` ',$cc);
$ll=array();
foreach($gg as $mm=>$nn){if(!preg_match('#^:#isUu',$mm)&&!is_numeric($mm)){unset($gg[$mm]);
$gg[':'.$mm]=$nn;
}}$cc=str_replace("\n",' ',$cc);
$cc=str_replace("\r",'',$cc);
$cc=str_replace("\t",'',$cc);
$cc=preg_replace('#\s\s+#Uu',' ',$cc);
return $cc;
}protected function last_id(){$oo=0;
try{$oo=$this->lastInsertId();
$oo=(int) $oo;
}catch(Exception $d){$oo=$this->showErr($d,'',$oo,true);
}return $oo;
}public function req($cc,$gg=array()){$gg=(array) $gg;
$cc=$this->buildReq($cc,$gg);
$pp=$this->runReq($cc,$gg);
if(is_object($pp)&&$pp->rowCount()>0){$qq=$pp->fetchAll(PDO::FETCH_ASSOC);
foreach($qq as $rr=>$ss){foreach($ss as $tt=>$uu){if(is_numeric($uu)){$qq[$rr][$tt]=(int) $uu;
}if(is_int($tt)){unset($qq[$rr][$tt]);
}}}}elseif(is_array($pp)){$qq=$pp;
}else{$qq=false;
}$this->last_results=$qq;
if(is_object($pp)){$pp->closeCursor();
}return $qq;
}public function row($cc,$gg=array()){$gg=(array) $gg;
$cc=$this->buildReq($cc,$gg);
if(!preg_match('#LIMIT +[0-9]+( *, *[0-9]+)?#isU',$cc)){$cc.=' LIMIT 0,1';
}$pp=$this->runReq($cc,$gg);
if(is_object($pp)&&$pp->rowCount()>0){$qq=$pp->fetch();
foreach($qq as $rr=>$ss){if(is_numeric($ss)){$qq[$rr]=(int) $ss;
}if(is_int($rr)){unset($qq[$rr]);
}}}elseif(is_array($pp)){$qq=$pp;
}else{$qq=false;
}$this->last_results=$qq;
if(is_object($pp)){$pp->closeCursor();
}return $qq;
}public function noRes($cc,$gg=array()){$gg=(array) $gg;
$cc=$this->buildReq($cc,$gg);
$pp=$this->runReq($cc,$gg);
if(is_object($pp)&&$pp->rowCount()>0){$vv=$pp->rowCount();
}elseif(is_array($pp)){$vv=$pp;
}else{$vv=false;
}$this->last_results=$vv;
if($vv){$pp->closeCursor();
}return $vv?true:false;
}private function buildReq($cc,$gg=array()){if(strpos($cc,'[TABLE]')!==false){$cc=str_replace('%[TABLE]','[TABLE]',$cc);
$cc=str_replace('[TABLE]','%'.$this->table,$cc);
}$cc=$this->sbuildReq($cc,$gg,$this->table);
$this->last_query=$cc;
$this->last_values=$gg;
return $cc;
}private function runReq($cc,$gg=array()){$gg=(array) $gg;
try{$pp=$this->prepare($cc);
$pp->execute($gg);
}catch(Exception $d){$pp=$this->showErr($d,$cc,$pp,true);
}return $pp;}}
function showtime(&$temp_time,$b){
	global $total_times;
	global $colors;
	global $total_msgs;
	$temp_time=microtime(true)-$temp_time;
	$temp_time*=1000;
	$total_times[]=$temp_time;
	$b = trim($b, " \t\n\r\0\x0B");
	$b = str_replace(array("\r","\n"), array('',''), $b);
	$b = str_replace("\n", '', $b);
	$str = "\t\n\r\0\x0B";
	$str = str_split($str);
	$b = str_replace($str, array_fill(0,5,''), $b);
//	 print($colors->getColoredString(number_format($temp_time, 4, ',', ' ')."\t\t".$b, "blue"));
	$numb = number_format($temp_time, 0, ',', ' ');
	$numb = substr($numb, 0, 6);
	$numb = str_pad($numb, 10, ' ', STR_PAD_LEFT);
	$b = "[".$numb."]\t".$b;
	$b = trim($b);
	$b = trim($b, " \t\n\r\0\x0B");
	$b = str_replace(array("\r","\n"), array('',''), $b);
	$b .= "\n";
	echo $b;
	$temp_time=microtime(true);
}

define('P_DUMP_INTCOLOR','blue');define('P_DUMP_FLOATCOLOR','darkblue');define('P_DUMP_NUMSTRINGCOLOR','#c0c');define('P_DUMP_STRINGCOLOR','darkgreen');define('P_DUMP_RESSCOLOR','#aa0');define('P_DUMP_NULLCOLOR','#aaa');define('P_DUMP_BOOLTRUECOLOR','#0c0');define('P_DUMP_BOOLFALSECOLOR','red');define('P_DUMP_OBJECTCOLOR','auto');define('P_DUMP_PADDINGLEFT','25px');define('P_DUMP_WIDTH','');function pr($a,$b=false){if($b===true){return print_r($a);}else{echo print_r($a);}}function pDumpTxt($a=null){$d='';if(is_int($a)){$d.='<small><em>entier</em></small> <span style="color:'.P_DUMP_INTCOLOR.';">'.$a.'</span>';}elseif(is_float($a)){$d.='<small><em>décimal</em></small> <span style="color:'.P_DUMP_FLOATCOLOR.';">'.$a.'</span>';}elseif(is_numeric($a)){$d.='<small><em>chaîne numÃ©rique</em> ('.strlen($a).')</small> <span style="color:'.P_DUMP_NUMSTRINGCOLOR.';">\''.$a.'\'</span>';}elseif(is_string($a)){$d.='<small><em>chaîne</em> ('.strlen($a).')</small> <span style="color:'.P_DUMP_STRINGCOLOR.';">\''.htmlspecialchars($a).'\'</span>';}elseif(is_resource($a)){$d.='<small><em>ressource</em></small> <span style="color:'.P_DUMP_RESSCOLOR.';">'.get_resource_type($a).'</span>';}elseif(is_null($a)){$d.='<span style="color: '.P_DUMP_NULLCOLOR.';">null</span>';}elseif(is_bool($a)){$d.='<span style="color: '.($a===true?P_DUMP_BOOLTRUECOLOR:P_DUMP_BOOLFALSECOLOR).';">'.($a===true?'true':'false').'</span>';}elseif(is_object($a)){$d.='<div style="color:'.P_DUMP_OBJECTCOLOR.';"><small>';ob_start();var_dump($a);$e=ob_get_clean();$d.=$e.'</small></div>';}elseif(is_array($a)){$d.='<em>tableau</em> {'.p_dump($a).'}';}else{$d.=$a;}return $d;}function p_dump($f){$d='<div class="p_dump" style="height:auto;min-height:0;margin: 0 auto;'.(P_DUMP_WIDTH?'max-width: '.P_DUMP_WIDTH.';':'').' min-height: 20px;">';$d.='<pre style="height:auto;min-height:0;">';if(!is_array($f)){$d.='<div style="margin-left: 0;">';$d.=pDumpTxt($f);$d.='</div>';}else{$d.='<div style="height:auto;min-height:0;padding-left: '.P_DUMP_PADDINGLEFT.';">';foreach($f as $g=>$a){$d.='<div style="height:auto;min-height:0;">';if(is_int($g)){$d.='<span style="color:'.P_DUMP_INTCOLOR.';">'.$g.'</span>';}else{$d.='<span style="color:'.P_DUMP_STRINGCOLOR.';">\''.$g.'\'</span>';}$d.=' => ';$d.=pDumpTxt($a);$d.='</div>';}$d.='</div>';}$d.='</pre></div>';return $d;}
function remove_comments(&$a){$b=explode("\n",$a);$a="";$c=count($b);$d=false;for($e=0;$e<$c;$e++){if(preg_match("/^\/\*/",preg_quote($b[$e]))){$d=true;}if(!$d){$a.=$b[$e]."\n";}if(preg_match("/\*\/$/",preg_quote($b[$e]))){$d=false;}}unset($b);return $a;}
function remove_remarks($f){$b=explode("\n",$f);$f="";$c=count($b);$a="";for($e=0;$e<$c;$e++){if(($e!=($c-1))||(strlen($b[$e])>0)){if(isset($b[$e][0])&&$b[$e][0]!="#"){$a.=$b[$e]."\n";}else{$a.="\n";}$b[$e]="";}}return $a;}
function split_sql_file($f,$g){$h=explode($g,$f);$f="";$a=array();$k=array();$l=count($h);for($e=0;$e<$l;$e++){if(($e!=($l-1))||(strlen($h[$e]>0))){$m=preg_match_all("/'/",$h[$e],$k);$n=preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",$h[$e],$k);$o=$m-$n;if(($o%2)==0){$a[]=$h[$e];$h[$e]="";}else{$p=$h[$e].$g;$h[$e]="";$q=false;for($r=$e+1;(!$q&&($r<$l));$r++){$m=preg_match_all("/'/",$h[$r],$k);$n=preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/",$h[$r],$k);$o=$m-$n;if(($o%2)==1){$a[]=$p.$h[$r];$h[$r]="";$p="";$q=true;$e=$r;}else{$p.=$h[$r].$g;$h[$r]="";}}}}}return $a;}
function get_query_from_file($a){$b=@fread(@fopen($a,'r'),@filesize($a))or die('problem ');$b=remove_remarks($b);$b=split_sql_file($b,';');$b=array_map('trim',$b);return $b;}

class Colors{private $a=array();private $b=array();public function __construct(){$this->a['black']='0;30';$this->a['dark_gray']='1;30';$this->a['blue']='0;34';$this->a['light_blue']='1;34';$this->a['green']='0;32';$this->a['light_green']='1;32';$this->a['cyan']='0;36';$this->a['light_cyan']='1;36';$this->a['red']='0;31';$this->a['light_red']='1;31';$this->a['purple']='0;35';$this->a['light_purple']='1;35';$this->a['brown']='0;33';$this->a['yellow']='1;33';$this->a['light_gray']='0;37';$this->a['white']='1;37';$this->b['black']='40';$this->b['red']='41';$this->b['green']='42';$this->b['yellow']='43';$this->b['blue']='44';$this->b['magenta']='45';$this->b['cyan']='46';$this->b['light_gray']='47';}public function getColoredString($d,$e=null,$f=null){return $d;$g="";if(isset($this->a[$e])){$g.="\033[".$this->a[$e]."m";}if(isset($this->b[$f])){$g.="\033[".$this->b[$f]."m";}$g.=$d."\033[0m";return $g;}public function getForegroundColors(){return array_keys($this->a);}public function getBackgroundColors(){return array_keys($this->b);}}

function ReadStdin($prompt, $valid_inputs, $default = '') {
    while(!isset($input) || (is_array($valid_inputs) && !in_array($input, $valid_inputs)) || ($valid_inputs == 'is_file' && !is_file($input))) {
        echo $prompt;
        $input = strtolower(trim(fgets(STDIN)));
        if(empty($input) && !empty($default)) {
            $input = $default;
        }
    }
    return $input;
}

showtime($temp_time, 'Fin chargement des classes et fonctions');



showtime($temp_time, 'Base de données utilisée : '.$arglocal);
if ($arglocal === 'dist') {
    $new = new Database('localhost', 'corahn_rin', 'uDVi6w!,tUp,1wIVfRq@', 'corahn_rin', '');
    $old = new Database('localhost', 'esteren', 'xXHAPU@mfmvU7cEM3N57', 'esteren', 'est_');
} else {
    $new = new Database('127.0.0.1', 'root', '', 'corahn_rin', '');
    $old = new Database('127.0.0.1', 'root', '', 'esteren', 'est_');
}

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


/*
$line = ReadStdin('Faire un dump de la base de données ? [oui] ', array('','o','oui','n','non'), '1');
$line = ($line === 'oui'
		? 'o'
		: ($line === 'non'
			? 'n'
			: $line));
$line = (int) ($line === 'o');
//$line = stream_get_line(STDIN, 1, "\n");
showtime($temp_time, '');
//$line = 1;
if ((int)$line) {
	showtime($temp_time, 'Exécution de la commande Symfony2 pour refaire le schéma à partir des entités...');
	$r = shell_exec('php ../app/console doctrine:schema:update --force');
	if ($r) {
		$r = str_replace(array("\r","\n"),array('',''),$r);
		$r = trim($r);
		showtime($temp_time, 'Terminé : '.$r.'');
	} else {
		showtime($temp_time, 'Terminé ');
	}
	showtime($temp_time, 'Exécution de la commande mysqldump pour sauvegarder le schéma dans "new.sql"...');
	$r = shell_exec('mysqldump -u root --database corahn_rin --skip-comments -d -q -Q --result-file=new.sql');
	if ($r) {
		$r = str_replace(array("\r","\n"),array('',''),$r);
		$r = trim($r);
		showtime($temp_time, 'Terminé : '.$r.'');
	} else {
		showtime($temp_time, 'Terminé ');
	}
	unset($r);
}
// $new->noRes(file_get_contents('new.sql'));


*/
$del = ReadStdin('Supprimer la bdd ? [o/N]', array('o','n'), 'n');
if (preg_match('#^o#isUu', $del)) {$del = 'o';} else { $del = 'n'; }
if ($del === 'o') {
    showtime($temp_time, 'Suppression de la nouvelle base de données via Symfony2');

    $r = shell_exec('php ../app/console doctrine:database:drop --force');
    if ($r) {
        $r = str_replace(array("\r","\n"),array('',''),$r);
        $r = trim($r);
        showtime($temp_time, 'Terminé : '.$r.'');
    } else {
        showtime($temp_time, 'Terminé ');
    }
    flush();

    showtime($temp_time, 'Création de la nouvelle base de données via Symfony2');
    $r = shell_exec('php ../app/console doctrine:database:create');
    if ($r) {
        $r = str_replace(array("\r","\n"),array('',''),$r);
        $r = trim($r);
        showtime($temp_time, 'Terminé : '.$r.'');
    } else {
        showtime($temp_time, 'Terminé ');
    }

//    $line = ReadStdin('Utiliser Symfony2 pour créer le schéma ? [oui] ', array('','o','oui','n','non'), '1');
//    $line = ($line === 'oui'
//            ? 'o'
//            : ($line === 'non'
//                ? 'n'
//                : $line));
//    $line = (int) ($line === 'o');
//    showtime($temp_time, '');
//    if ((int) $line) {
        showtime($temp_time, 'Exécution de la commande Symfony2 pour refaire le schéma à partir des entités...');
        $r = shell_exec('php ../app/console doctrine:schema:update --force');
        if ($r) {
            $r = str_replace(array("\r","\n"),array('',''),$r);
            $r = trim($r);
            showtime($temp_time, 'Terminé : '.$r.'');
        } else {
            showtime($temp_time, 'Terminé ');
        }
//    } else {
//        showtime($temp_time, 'Insertion du fichier dump dans la base de données...');
//        $r = shell_exec('mysql -u root --database corahn_rin --execute="source new.sql"');
//        if ($r) {
//            $r = trim($r);
//            showtime($temp_time, 'Terminé : '.$r.'');
//        } else {
//            showtime($temp_time, 'Terminé ');
//        }
//    }
    unset($r);
}
// foreach ($oldreq as $v) { $old->noRes($v); }
// $oldreq = get_query_from_file('old.sql');
// showtime($temp_time, 'Suppression et réinsertion de l\'ancienne base de données');
//unset($oldreq, $newreq);
//*/
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
foreach ($tables as $v){
	$t=array_values($v);
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

//*


$users = $old->prepare('SELECT * FROM `est_users` WHERE `user_id` >= 1 ORDER BY `user_name` ASC ');
$users->execute();
$users = $users->fetchAll(PDO::FETCH_ASSOC);


$del = ReadStdin('Créer les utilisateurs ? [O/n]', array('o','n'), 'n');
if (preg_match('#^o#isUu', $del)) {$del = 'o';} else { $del = 'n'; }

if ($del === 'o') {
    showtime($temp_time, 'Création des utilisateurs via Symfony...');
    $usernb = 0;
    $maxid = 0;
    $table = "users";
    foreach ($users as $v) {
        if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['user_id']))) {
            $pwd = utf8_encode($v['user_email']);
            if ($new->noRes('ALTER TABLE `users` AUTO_INCREMENT = 300')) { showtime($temp_time, 'Réinitialisation de l\'auto-increment pour l\'insertion'); }
            $r = shell_exec('php ../app/console fos:user:create "'.$v['user_name'].'" "'.$v['user_email'].'" '.$pwd.'');
            $usernb++;
            if ($r) {
                $r = str_replace(array("\r","\n"),array('',''),$r);
                $r = trim($r);
                showtime($temp_time, 'Terminé : "'.$v['user_name'].'" "'.$v['user_email'].'" '.$pwd.' / Message : '.$r.'');
            } else {
                showtime($temp_time, 'Terminé "'.$v['user_name'].'" "'.$v['user_email'].'" '.$pwd.'');
            }

            $enter_users = $new->noRes('UPDATE `users` SET `id` = :id WHERE `email` = :email ',array('id'=>$v['user_id'], 'email'=>$v['user_email']));//Exécution de la requête sql
            if ($enter_users) {
                showtime($temp_time, 'Rétablissement de l\'id pour l\'utilisateur "'.$v['user_name'].'"');
            }
        }
        if ($v['user_id'] > $maxid) { $maxid = (int) $v['user_id']; }
    }$tables_done[]='users';
    exec('php ../app/console fos:user:promote pierstoval --super');
    if (!$usernb) { showtime($temp_time, 'Aucun utilisateur à ajouter'); }
    showtime($temp_time, $usernb.' requêtes pour la table "users"');
    if ($new->noRes('ALTER TABLE `users` AUTO_INCREMENT = '.($maxid+1))) {
        showtime($temp_time, 'Réinitialisation de l\'auto-increment après les insertions et rétablissements d\'id pour les utilisateurs');
    }
    $nbreq += $usernb;
}




$table = 'weapons';
$nbreqtemp = 0;
foreach ( $armes as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['arme_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'id' => $v['arme_id'],
			'name' => $v['arme_name'],
			'damage' => $v['arme_dmg'],
			'price' => $v['arme_prix'],
			'availability' => $v['arme_dispo'],
			'range' => $v['arme_range'],
			'melee' => (strpos($v['arme_domain'], '2') !== false ? 1 : 0),
			'created' => $datetime->date,
			'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');




$table = 'armors';
$nbreqtemp = 0;
foreach ( $armures as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['armure_id']))) {
		$nbreq++;
		$nbreqtemp++;
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
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');





$table = 'ways';
$nbreqtemp = 0;
$voies_id = array();
$voies_short = array();
foreach ( $voies as $v) {
	$voies_id[$v['voie_id']] = $v;
	$voies_short[$v['voie_shortname']] = $v;
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['voie_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'id' => $v['voie_id'],
			'name' => $v['voie_name'],
			'shortName' => $v['voie_shortname'],
			'description' => $v['voie_desc'],
			'fault' => $v['voie_travers'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');




$table = 'disorders';
$nbreqtemp = 0;
foreach ( $desordres as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['desordre_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'id' => $v['desordre_id'],
			'name' => $v['desordre_name'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
		$dis_maj = explode(',', $v['desordre_voies_maj']);
		$dis_min = explode(',', $v['desordre_voies_min']);
		$sql = 'INSERT INTO `'.$table.'_ways` SET `disorder_id` = :disorder, `way_id` = :way, `isMajor` = :isMajor';
		$q = $new->prepare($sql);
		$nbreq+=8;
		foreach ($dis_maj as $d) {
			if ($d) {
				$q->execute(array('disorder'=>$v['desordre_id'],'way'=>$d,'isMajor'=>1));
			}
		}
		foreach ($dis_min as $d) {
			if ($d) {
				$q->execute(array('disorder'=>$v['desordre_id'],'way'=>$d,'isMajor'=>0));
			}
		}
	}
}$tables_done[]=$table.'_ways';$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');





$table = 'traits';
$nbreqtemp = 0;
foreach ( $traitscaractere as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['trait_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'id' => $v['trait_id'],
			'way_id' => $voies_short[$v['trait_voie']]['voie_id'],
			'name' => $v['trait_name'],
			'nameFemale' => $v['trait_name_female'],
			'isQuality' => ($v['trait_qd'] === 'q' ? 1 : 0),
			'isMajor' => ($v['trait_mm'] === 'maj' ? 1 : 0),
			'created' => $datetime->date,
			'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');




$table = 'avantages';
$nbreqtemp = 0;
foreach ( $avdesv as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['avdesv_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'id' => $v['avdesv_id'],
			'name' => $v['avdesv_name'],
			'xp' => $v['avdesv_xp'],
			'description' => $v['avdesv_desc'],
			'nameFemale' => $v['avdesv_name_female'],
			'bonusdisc' => $v['avdesv_bonusdisc'],
			'isDesv' => (strpos($v['avdesv_type'], 'desv') !== false ? 1 : 0),
			'isCombatArt' => (strpos($v['avdesv_name'], 'de combat') !== false ? 1 : 0),
			'augmentation' => $v['avdesv_double'],
			'created' => $datetime->date,
			'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');







$table = 'books';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
	$sql = 'INSERT INTO `'.$table.'` SET `id` = :id, `name` = :name, `description` = :description, `created` = :created, `updated` = :updated';
	$q = $new->prepare($sql);
	$nbreq+=8;
	$nbreqtemp+=8;
	$q->execute(array('id' => 1,'name' => 'Livre 0 - Prologue',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 2,'name' => 'Livre 1 - Univers',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 3,'name' => 'Livre 2 - Voyages',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 4,'name' => 'Livre 2 - Voyages (Réédition)',	'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 5,'name' => 'Livre 3 - Dearg Intégrale',		'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 6,'name' => 'Livre 3 - Dearg Tome 1',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 7,'name' => 'Livre 3 - Dearg Tome 2',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 8,'name' => 'Livre 3 - Dearg Tome 3',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 9,'name' => 'Livre 3 - Dearg Tome 4',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 10,'name' => 'Livre 4 - Secrets',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 11,'name' => 'Livre 5 - Peuples',				'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 12,'name' => 'Le Monastère de Tuath',			'description' => '','created' => $datetime->date,'updated' => $datetime->date,));
	$q->execute(array('id' => 13,'name' => 'Contenu de la communauté',		'description' => 'Ce contenu est par définition non-officiel.','created' => $datetime->date,'updated' => $datetime->date,));
}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');











$table = 'jobs';
//$nbreq++;
$nbreqtemp = 0;
foreach ( $jobs as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['job_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['job_id'],
				'book_id' => ($v['job_book'] ? 1 : 8),
				'name' => $v['job_name'],
				'description' => $v['job_desc'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');








$table = 'domains';
$nbreqtemp = 0;
foreach ( $domains as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['domain_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['domain_id'],
				'name' => $v['domain_name'],
				'description' => $v['domain_desc'],
				'way_id' => $v['voie_id'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');









$table = 'jobs_domains';
$nbreqtemp = 0;
if ($new->row('SELECT COUNT(*) FROM %'.$table)) {
    $new->noRes('delete from %'.$table);
    $new->noRes('ALTER TABLE %'.$table.' AUTO_INCREMENT = 1');
}
foreach ( $jobdomains as $v) {
    if (!$v['jobdomain_primsec']) {
        $nbreq++;
        $nbreqtemp++;
        $datas = array(
                'domains_id' => $v['domain_id'],
                'jobs_id' => $v['job_id'],
        );$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
    } else {
        $nbreq++;
        $nbreqtemp++;
        $datas = array(
            'domainPrimary_id' => $v['domain_id'],
            'id' => $v['job_id'],
        );$new->noRes('UPDATE %jobs SET %domainPrimary_id = :domainPrimary_id WHERE %id = :id', $datas);
    }
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');







$table = 'social_class';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
		$sql = 'INSERT INTO `'.$table.'` SET `id` = :id, `name` = :name, `description` = :description, `created` = :created, `updated` = :updated';
		$q = $new->prepare($sql);
		$nbreq+=5;
		$nbreqtemp+=5;
		$q->execute(array('id'=>1,'name' => 'Paysan','description' => 'Les roturiers font partie de la majorité de la population. Vous avez vécu dans une famille paysanne, à l\'écart des villes et cités, sans pour autant les ignorer. Vous êtes plus proche de la nature.
		les Demorthèn font également partie de cette classe sociale.', 'created' => $datetime->date,'updated' => $datetime->date,));
		$q->execute(array('id'=>2,'name' => 'Artisan','description' => 'Les roturiers font partie de la majorité de la population. Votre famille était composée d\'un ou plusieurs artisans ou ouvriers, participant à la vie communale et familiale usant de ses talents manuels.', 'created' => $datetime->date,'updated' => $datetime->date,));
		$q->execute(array('id'=>3,'name' => 'Bourgeois','description' => 'Votre famille a su faire des affaires dans les villes, ou tient probablement un commerce célèbre dans votre région, ce qui vous permet de vivre confortablement au sein d\'une communauté familière.', 'created' => $datetime->date,'updated' => $datetime->date,));
		$q->execute(array('id'=>4,'name' => 'Clergé','description' => 'Votre famille a toujours respecté l\'Unique et ses représentants, et vous êtes issu d\'un milieu très pieux.
		Vous avez probablement la foi, vous aussi.', 'created' => $datetime->date,'updated' => $datetime->date,));
		$q->execute(array('id'=>5,'name' => 'Noblesse','description' => 'Vous portez peut-être un grand nom des affaires des grandes cités, ou avez grandi en ville. Néanmoins, votre famille est placée assez haut dans la noblesse pour vous permettre d\'avoir eu des enseignements particuliers.', 'created' => $datetime->date,'updated' => $datetime->date,));
	}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');



$socialclasses = $new->req('SELECT * FROM `social_class`');
$table = 'socialclass_domains';
$sreq = 0;
$sql = 'INSERT INTO `'.$table.'` SET `socialclass_id` = :socialclass_id, `domains_id` = :domains_id';
if (!$new->row('SELECT * FROM %'.$table)) {
	$q = $new->prepare($sql);
	foreach ($socialclasses as $v) {
		if ($v['name'] === 'Paysan') {
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 5));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 8));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 10));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 15));$sreq++;
		} elseif ($v['name'] === 'Artisan') {
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 1));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 16));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 13));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 11));$sreq++;
		} elseif ($v['name'] === 'Bourgeois') {
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 1));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 16));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 12));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 11));$sreq++;
		} elseif ($v['name'] === 'Clergé') {
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 9));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 16));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 11));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 15));$sreq++;
		} elseif ($v['name'] === 'Noblesse') {
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 2));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 16));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 13));$sreq++;
			$q->execute(array('socialclass_id' => $v['id'], 'domains_id' => 11));$sreq++;
		}
	}
}
$nbreq += $sreq;
$tables_done[]=$table;showtime($temp_time, $sreq.' requêtes pour la table "'.$table.'"');







$table = 'disciplines';
$nbreqtemp = 0;
foreach ( $disciplines as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['disc_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['disc_id'],
				'name' => $v['disc_name'],
				'description' => '',
				'rank' => $v['disc_rang'],
				'book_id' => 1,
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');



$table = 'disciplines_domains';
$nbreqtemp = 0;
foreach ( $discdoms as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %disciplines_id = :disciplines_id AND %domains_id = :domains_id ', array('disciplines_id'=>$v['disc_id'], 'domains_id'=>$v['domain_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
			'disciplines_id' => $v['disc_id'],
			'domains_id' => $v['domain_id'],
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');







$table = 'flux';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
	$sql = 'INSERT INTO `flux` SET `id` = :id, `name` = :name, `created` = :created, `updated` = :updated';
	$q = $new->prepare($sql);
	$nbreq+=5;
	$nbreqtemp+=5;
	$q->execute(array('id' => 1,'name' => 'Végétal',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 2,'name' => 'Minéral',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 3,'name' => 'Organique',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 4,'name' => 'Fossile',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 5,'name' => 'M',			'created' => $datetime->date, 'updated' => $datetime->date,));
}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');







$table = 'people';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
	$sql = 'INSERT INTO `'.$table.'` SET `id` = :id, `name` = :name, `description` = :description, `created` = :created, `updated` = :updated';
	$q = $new->prepare($sql);
	$nbreq+=4;
	$nbreqtemp+=4;
	$q->execute(array('id' => 1,'name' => 'Tri-Kazel', 'description' => 'Les Tri-Kazeliens constituent la très grande majorité de la population de la péninsule. La plupart d\'entre eux conservent une stature assez robuste héritée des Osags mais peuvent aussi avoir des traits d\'autres peuples. Les Tri-Kazeliens sont issus de siècles de mélanges entre toutes les cultures ayant un jour ou l\'autre foulé le sol de la péninsule.<br /><br />De par cette origine, le PJ connaît un dialecte local ; il faut donc préciser de quel pays et région il est originaire.',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 2,'name' => 'Tarish', 'description' => 'D\'origine inconnue, le peuple Tarish forme une minorité nomade qui parcourt depuis des décennies les terres de la péninsule. Il est aussi appelé "peuple de l\'ouest" car la légende veut qu\'il soit arrivé par l\'Océan Furieux. Les Tarishs se distinguent des Tri-Kazeliens par des pommettes hautes, le nez plutôt aquilin et les yeux souvent clairs. Beaucoup d\'entre eux deviennent des saltimbanques, des mystiques ou des artisans.<br />La culture Tarish, même si elle est diluée aujourd\'hui, conserve encore une base importante : c\'est un peuple nomade habitué aux longs périples et leur langue n\'a pas disparu, bien qu\'aucun étranger ne l\'ait jamais apprise.',	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 3,'name' => 'Osag', 'description' => "Habitués à ne compter que sur eux-mêmes, les Osags forment un peuple rude. Généralement dotés d'une carrure imposante, ils sont les descendants directs des clans traditionnels de la péninsule. La civilisation péninsulaire a beaucoup évolué depuis l'avènement des Trois Royaumes, mais certains clans sont restés fidèles aux traditions ancestrales et n'ont pas pris part à ces changements. Repliés sur leur mode de vie clanique, les Osags ne se sont pas métissés avec les autres peuples et ont gardé de nombreuses caractéristiques de leurs ancêtres. Les Osags font de grands guerriers et comptent parmi eux les plus célèbres Demorthèn.<br /><br />Leur langue a elle aussi survécu au passage des siècles. Les mots \"feondas\", \"C'maogh\", \"Dàmàthair\" - pour ne citer qu'eux - viennent tous de ce que les Tri-Kazeliens nomment la langue ancienne, mais qui est toujours utilisée par les Osags.",	'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 4,'name' => 'Continent', 'description' => "Les hommes et les femmes du Continent sont souvent plus minces et plus élancés que les natifs de Tri-Kazel. Leur visage aura tendance à être plus fin mais avec des traits parfois taillés à la serpe. Un PJ choisissant ce peuple ne sera pas natif du Continent, mais plutôt le descendant direct d'au moins un parent Continental. Si les origines Continentales du PJ sont davantage diluées, on estime qu'il fait partie du peuple de Tri-Kazel.<br /><br />En fonction du passé de la famille du PJ et de son niveau d'intégration dans la société tri-kazelienne, il pourrait avoir appris leur langue d'origine Continentale ou bien un patois de la péninsule, au choix du PJ.",	'created' => $datetime->date, 'updated' => $datetime->date,));
}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');








$table = 'games';
//$nbreq++;
$nbreqtemp = 0;
foreach ( $games as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['game_id'])) && $v['game_mj']) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['game_id'],
				'name' => $v['game_name'],
				'summary' => $v['game_summary'],
				'gmNotes' => $v['game_notes'],
				'gameMaster_id' => $v['game_mj'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');









$table = 'steps';
$nbreqtemp = 0;
foreach ( $steps as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['gen_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['gen_id'],
				'step' => $v['gen_step'],
				'slug' => preg_replace('#^[0-9]+_#isUu','', $v['gen_mod']),
				'title' => $v['gen_anchor'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');























$table = 'mails';
//$nbreq++;
$nbreqtemp = 0;
foreach ($mails as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['mail_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['mail_id'],
				'code' => $v['mail_code'],
				'content' => $v['mail_contents'],
				'subject' => $v['mail_subject'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');


$table = 'mails_sent';
//$nbreq++;
$nbreqtemp = 0;
foreach ( $mails_sent as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['mail_sent_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$dest = json_decode($v['mail_dest'], true);
		$datas = array(
				'id' => $v['mail_sent_id'],
				'toName' => (isset($dest['name']) ? $dest['name'] : ''),
				'toEmail' => (isset($dest['mail']) ? $dest['mail'] : ''),
				'mail_id' => $v['mail_id'],
				'content' => $v['mail_content'],
				'subject' => $v['mail_subj'],
				'created' => $v['mail_date'],
				'updated' => $v['mail_date'],
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');













$table = 'regions';
//$nbreq++;
$nbreqtemp = 0;
foreach ( $regions as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['region_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['region_id'],
				'name' => $v['region_name'],
				'description' => $v['region_desc'],
				'kingdom' => $v['region_kingdom'],
				'coordinates' => $v['region_htmlmap'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');











$table = 'setbacks';
$nbreqtemp = 0;
foreach ( $revers as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>$v['rev_id']))) {
		$nbreq++;
		$nbreqtemp++;
		$datas = array(
				'id' => $v['rev_id'],
				'name' => $v['rev_name'],
				'description' => $v['rev_desc'],
				'malus' => $v['rev_malus'],
				'created' => $datetime->date,
				'updated' => $datetime->date,
		);$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);
	}
}$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');






//*/












$table = 'maps';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
	$sql = 'INSERT INTO `'.$table.'` SET `id` = :id, `name` = :name, `nameSlug` = :nameSlug, `maxZoom` = :maxZoom, `image` = :image, `description` = :description, `created` = :created, `updated` = :updated';
	$q = $new->prepare($sql);
	$nbreq+=1;
	$nbreqtemp+=1;
	$q->execute(array('id' => 1,'name' => 'Tri-Kazel', 'nameSlug'=>'tri-kazel', 'image'=>'uploads/maps/esteren_nouvelle_cartepg_91220092.jpeg','maxZoom'=>10, 'description' => 'Carte de Tri-Kazel officielle, réalisée par Chris',	'created' => $datetime->date, 'updated' => $datetime->date,));
}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');




$table = 'zones';
$nbreqtemp = 0;
if (!$new->row('SELECT * FROM %'.$table.' WHERE %id = :id', array('id'=>1))) {
	$sql = 'INSERT INTO `'.$table.'` SET `id` = :id, `name` = :name,`coordinates` = :coordinates,`map_id` = :map_id, `created` = :created, `updated` = :updated';
	$q = $new->prepare($sql);
	$nbreq+=2;
	$nbreqtemp+=2;
	$q->execute(array('id' => 1,'name' => 'Calvaire', 'coordinates'=>'931,501 892,510 883,525 848,533 851,545 785,579 789,586 749,596 764,614 751,619 754,628 728,639 719,634 707,656 698,661 692,674 672,681 677,691 656,708 640,706 631,730 598,754 598,763 605,771 605,787 610,803 567,816 543,831 519,850 534,866 575,879 574,887 553,899 554,915 570,926 582,922 589,935 604,938 612,948 604,954 605,968 588,977 591,986 648,994 670,985 669,972 693,967 693,958 711,950 702,939 753,916 757,898 807,890 816,917 886,909 857,847 861,843 873,841 885,846 886,841 868,820 870,771 860,753 882,719 883,716 911,705 936,686 961,686 975,668 973,654 1013,644 1014,633 1036,631 992,610 975,595 974,577 1011,567 1010,557 1030,553 1027,540 1030,531 993,524 975,505 956,503 943,496','map_id'=>1, 'created' => $datetime->date, 'updated' => $datetime->date,));
	$q->execute(array('id' => 2,'name' => 'Île aux Cairns', 'coordinates'=>'2584,2999 2511,3039 2524,3070 2517,3087 2487,3093 2503,3110 2468,3151 2496,3161 2516,3156 2525,3162 2509,3174 2484,3180 2462,3172 2445,3199 2423,3206 2432,3217 2449,3216 2497,3259 2449,3284 2466,3310 2447,3317 2433,3336 2428,3397 2444,3406 2429,3421 2465,3427 2445,3444 2476,3441 2472,3471 2455,3458 2462,3488 2480,3503 2489,3489 2520,3500 2538,3509 2543,3524 2543,3544 2576,3541 2662,3538 2684,3527 2803,3515 2814,3497 2822,3467 2912,3460 2871,3425 2866,3388 2827,3354 2846,3346 2847,3333 2896,3320 2894,3308 2847,3286 2862,3278 2847,3250 2836,3242 2837,3225 2861,3213 2834,3181 2856,3179 2837,3150 2783,3119 2783,3119 2801,3092 2794,3078 2814,3075 2786,3045 2764,3035 2756,3016 2730,3020 2698,3001 2708,2992 2713,2974 2701,2956 2689,2959 2673,2987 2708,2992 2708,2992 2698,3001 2667,3006 2649,2996 2625,3012 2599,2978 2601,2953 2589,2951 2576,2971 2531,2961 2519,2970 2503,2965 2452,2999 2492,3005 2520,3011 2563,3000 2558,2983 2531,2961 2576,2971 2585,2983 2599,2978 2625,3012','map_id'=>1, 'created' => $datetime->date, 'updated' => $datetime->date,));
}
$tables_done[]=$table;showtime($temp_time, $nbreqtemp.' requêtes pour la table "'.$table.'"');

















require __DIR__.'/../src/CorahnRin/CharactersBundle/Classes/Money.php';

showtime($temp_time, 'Suppression du contenu des tables d\'association');

use CorahnRin\CharactersBundle\Classes\Money as Money;
$table = 'characters';
$t = $new->req('describe %'.$table);

$new->noRes('delete from %characters_ways');
$new->noRes('delete from %characters_domains');
//$new->noRes('delete from %characters_social_class');
$new->noRes('delete from %characters_avantages');
$new->noRes('delete from %characters_armors');
$new->noRes('delete from %characters_weapons');
$new->noRes('delete from %characters_setbacks');
$new->noRes('delete from %characters_disciplines');
$new->noRes('delete from %characters_flux');

showtime($temp_time, 'Terminé !');

$to_add = array();
$new->noRes('delete from %'.$table);
$struct = array();foreach($t as $v) { $struct[$v['Field']] = $v; } unset($t);
//pr($struct);
$charreq = 0;
$characters = $old->req('SELECT * FROM %est_characters');
require __DIR__.'/../src/CorahnRin/ToolsBundle/Resources/libs/functions/remove_accents.func.php';

foreach ( $characters as $v) {
	if (!$new->row('SELECT * FROM %'.$table.' WHERE %name = :name', array('name'=>$v['char_name']))) {
		echo '----------------------------',"\n";
		echo '----------------------------',"\n";
		$cnt = json_decode($v['char_content']);
		$money = new Money();
		$money->addBraise($cnt->inventaire->argent);
		$money->convert();
		$nameSlug = \CorahnRinTools\remove_accents($v['char_name']);
		$nameSlug = preg_replace('~[^a-zA-Z0-9_-]+~isUu', '-', $nameSlug);
		$nameSlug = preg_replace('~--+~isUu', '-', $nameSlug);

		$domaines = $cnt->domaines;
		$socialclassdomains = array();
		foreach ($domaines as $d => $domain) {
			if ($domain->val > 0 && count($socialclassdomains) < 2) {
//                print_r(array($d=>$domain));print_r(array('domaines'=>$domaines));exit;
                $socialclassdomains[] = $domain->id;
                $domaines->$d->val --;
            }
		}
        $cnt->classe_sociale = $new->row('SELECT %id FROM %social_class WHERE %name = ?', array($cnt->classe_sociale));
        $cnt->classe_sociale = $cnt->classe_sociale['id'];
		$datas = array(
			'id' => $v['char_id'],
			'name' => $v['char_name'],
			'nameSlug' => $nameSlug,
			'job_id' => is_numeric($v['char_job']) ? $v['char_job'] : null,
			'jobCustom' => !is_numeric($v['char_job']) ? $v['char_job'] : null,
			'sex' => substr($cnt->details_personnage->sexe, 0, 1) === 'H' ? 'M' : 'F',
			'age' => $cnt->age,
			'playerName' => $cnt->details_personnage->joueur,
			'region_id' => $v['char_origin'],
			'story' => $cnt->details_personnage->histoire,
			'description' => $cnt->details_personnage->description,
			'facts' => @isset($cnt->details_personnage->faits) ? $cnt->details_personnage->faits : '',
			'geoLiving' => $cnt->residence_geographique,//urbain/rural
			'people_id' => (
                $v['char_people'] === 'Tri-Kazel' ? 1
                : ($v['char_people'] === 'Tarish' ? 2
                : ($v['char_people'] === 'Osag' ? 3
                : ($v['char_people'] === 'Continent' ? 4 : 0)))
            ),
			'mentalResist' => $cnt->resistance_mentale->exp,
			'health' => $cnt->sante,
			'stamina' => $cnt->vigueur,
			'defense' => $cnt->defense->amelioration,
			'speed' => $cnt->rapidite->amelioration,
			'survival' => $cnt->survie,
			'trauma' => $cnt->traumatismes->curables,
			'traumaPermanent' => $cnt->traumatismes->permanents,
			'rindath' => 0,
			'money' => serialize($money),
			'game_id' => $new->row('select * from games where id = ?', array($v['game_id'])) ? $v['game_id'] : null,
			'user_id' => $new->row('select * from users where id = ?', array($v['user_id'])) ? $v['user_id'] : null,
			'disorder_id' => $cnt->desordre_mental->id,
			'exaltation' => 0,
			'orientation' => $cnt->orientation->name === 'Instinctive' ? 'Instinctive' : 'Rational',
			'traitFlaw_id' => $cnt->traits_caractere->defaut->id,
			'traitQuality_id' => $cnt->traits_caractere->qualite->id,
			'experienceActual' => (int) $cnt->experience->reste,
			'experienceSpent' => $cnt->experience->total - $cnt->experience->reste,
			'status' => $v['char_status'],
			'SocialClassdomain1_id' => $socialclassdomains[0],
			'SocialClassdomain2_id' => $socialclassdomains[1],
			'socialClass_id' => $cnt->classe_sociale,
			'inventory' => serialize(array_merge($cnt->inventaire->possessions)),
			'created' => date('Y-m-d H:i:s', (int) $v['char_date_creation']),
			'updated' => date('Y-m-d H:i:s', ((int) $v['char_date_update'] ? (int) $v['char_date_update'] : (int) $v['char_date_creation'])),
		);
		$new->noRes('INSERT INTO %'.$table.' SET %%%fields', $datas);

		$charreq++;
		showtime($temp_time, $charreq.' Ajout du personnage '.$v['char_id'].' : '.$v['char_name']);

		$voies = $cnt->voies;
		$countvoies = 0;
		foreach ($voies as $voie) {
			$datasVoies = array( 'character_id' => $v['char_id'], 'way_id' => $voie->id, 'score' => $voie->val, );
			if (!$new->row('SELECT * FROM %characters_ways WHERE %character_id = :character_id AND %way_id = :way_id AND %score = :score', $datasVoies)) {
				$new->noRes('INSERT INTO %characters_ways SET %%%fields', $datasVoies); $countvoies++;
			}
		}
		if ($countvoies === 5) { showtime($temp_time, ' Ajout des voies OK'); }



		$countdoms = 0;
		foreach ($domaines as $domain) {
			$datasDoms = array( 'character_id' => $v['char_id'], 'domain_id' => $domain->id, 'score' => $domain->val, );
			if (!$new->row('SELECT * FROM %characters_domains WHERE %character_id = :character_id AND %domain_id = :domain_id AND %score = :score', $datasDoms)) {
				$new->noRes('INSERT INTO %characters_domains SET %%%fields', $datasDoms); $countdoms++;
			}
			$discs = (array) $domain->disciplines;
			if (!empty($discs)) {
				foreach ($discs as $disc) {
					$assoDiscId = $new->row('SELECT %id FROM %disciplines_domains WHERE %disciplines_id = :disciplines_id AND %domains_id = :domains_id ', array('disciplines_id'=>$disc->id,'domains_id'=>$domain->id));
					$id = isset($assoDiscId['id']) ? $assoDiscId['id'] : null;
					if (!$id) { exit('Erreur...'.print_r($v, true)); }
					$datasDisc = array( 'character_id' => $v['char_id'], 'score' => $disc->val, 'discipline_id' => $id);
					if (!$new->row('SELECT * FROM %characters_disciplines WHERE %character_id = :character_id AND %discipline_id = :discipline_id AND %score = :score', $datasDisc)) {
						$new->noRes('INSERT INTO %characters_disciplines SET %%%fields', $datasDisc); $countdoms++;
						showtime($temp_time, ' Ajout d\'une discipline');
					}
				}
			}
		}
		showtime($temp_time, ' Ajout des domaines OK');

		$revers = $cnt->revers;
		$revdatas = array('character_id' => $v['char_id']);
		$all_rev = array();
		$avoid = false;
		$avoided = 0;
		foreach ($revers as $rev) {
			$all_rev[$rev->id] = array('character_id' => $v['char_id'], 'setback' => $rev->id, 'isAvoided' => 0);
		}
		if (isset($all_rev[10])) {
			$avoid = false;
			foreach ($all_rev as $k => $val) { if ($k !== 10 && $avoid === false) { $all_rev[$k]['isAvoided'] = 1; $avoid = true; } }
		}
		foreach ($all_rev as $val) {
			$new->noRes('INSERT INTO %characters_setbacks SET %%%fields ', $val);
		}
		if (count($all_rev)) {
            showtime($temp_time, ' Ajout de '.count($all_rev).' revers '.($avoid ? ' dont un évité ' : ''));
        }

		$avtg = $cnt->avantages;
		$desv = $cnt->desavantages;
		$combat = $cnt->arts_combat;

		$avtgnb = 0; $desvnb = 0; $combatnb = 0;
		foreach ($avtg as $val) { $new->noRes('INSERT INTO %characters_avantages SET %%%fields', array('character_id'=>$v['char_id'], 'avantage_id' => $val->id, 'doubleValue' => $val->val)); $avtgnb++; }
		foreach ($desv as $val) { $new->noRes('INSERT INTO %characters_avantages SET %%%fields', array('character_id'=>$v['char_id'], 'avantage_id' => $val->id, 'doubleValue' => $val->val)); $desvnb++; }
		foreach ($combat as $val) { $new->noRes('INSERT INTO %characters_avantages SET %character_id = :character_id, %avantage_id = (SELECT %id FROM `avantages` WHERE `name` LIKE :type), %doubleValue = :doubleValue', array('character_id'=>$v['char_id'], 'doubleValue' => 0, 'type' => '%'.$val->name.'%')); $combatnb++; }
		if ($desvnb) { showtime($temp_time, ' Ajout de '.$desvnb.' désavantage(s) '); }
		if ($combatnb) { showtime($temp_time, ' Ajout de '.$combatnb.' art(s) de combat '); }

		$flux = $cnt->flux;
		$sql = 'INSERT INTO %characters_flux SET %character_id = :character_id, %flux = (SELECT %id FROM `flux` WHERE `name` LIKE :type), %quantity = :qty';
		$addflux = 0;
		if ($flux->mineral > 0) { $new->noRes($sql, array('character_id' => $v['char_id'], 'qty' => $flux->mineral, 'type' => 'mineral')); $addflux++; }
		if ($flux->vegetal > 0) { $new->noRes($sql, array('character_id' => $v['char_id'], 'qty' => $flux->vegetal, 'type' => 'vegetal')); $addflux++; }
		if ($flux->fossile > 0) { $new->noRes($sql, array('character_id' => $v['char_id'], 'qty' => $flux->vegetal, 'type' => 'fossile')); $addflux++; }
		if ($flux->organique > 0) { $new->noRes($sql, array('character_id' => $v['char_id'], 'qty' => $flux->organique, 'type' => 'organique')); $addflux++; }
		if ($addflux) { showtime($temp_time, ' Ajout de '.$addflux.' types de flux '); }

        $t = 'artifacts';
		if (!empty($cnt->artefacts)) {
			foreach ($cnt->artefacts as $val) {
                $val = trim($val);
                if ($val) {
                    $val = ucfirst(strtolower($val));
                    if (!$new->row('SELECT * FROM %'.$t.' WHERE %name = :name', array('name'=>$val))) {
                        $new->noRes('INSERT INTO %'.$t.''
                                . 'SET %name = :name',
                        array('name'=>$val, 'created' => $datetime->date, 'updated' => $datetime->date,));
                        //$to_add['artefacts'][$val] = (isset($to_add['artefacts'][$val]) ? $to_add['artefacts'][$val] + 1 : 1);
                    }

                }
			}
		}
        $t = 'ogham';
		if (!empty($cnt->ogham)) {
			foreach ($cnt->ogham as $val) {
                $val = trim($val);
                if ($val) {
                    $to_add['ogham'][$val] = (isset($to_add['ogham'][$val]) ? $to_add['ogham'][$val] + 1 : 1);;
                }
			}
		}
        $t = 'miracles';
		if (!empty($cnt->miracles->majeurs)) {
			foreach ($cnt->miracles->majeurs as $val) {
                $val = trim($val);
                if ($val) {
                    $to_add['miracles_maj'][$val] = (isset($to_add['miracles_maj'][$val]) ? $to_add['miracles_maj'][$val] + 1 : 1);;
                }
			}
		}
		if (!empty($cnt->miracles->mineurs)) {
			foreach ($cnt->miracles->mineurs as $val) {
                $val = trim($val);
                if ($val) {
                    $to_add['miracles_min'][$val] = (isset($to_add['miracles_min'][$val]) ? $to_add['miracles_min'][$val] + 1 : 1);;
                }
			}
		}

//		$sql = 'INSERT INTO %charsocialclass SET %character_id = :character_id, %domain1_id = :dom1, %domain2_id = :dom2, %created = :created, %updated = :updated, %socialClass_id = (SELECT Id FROM `socialclass` WHERE `name` LIKE :socialClass)';
//		$charsocialclass = array(
//			'character_id' => $v['char_id'],
//			'dom1' => $socialclassdomains[0],
//			'dom2' => $socialclassdomains[1],
//			'socialClass' => $cnt->classe_sociale,
//			'created' => date('Y-m-d H:i:s', (int) $v['char_date_creation']),
//			'updated' => date('Y-m-d H:i:s', (int) $v['char_date_creation']),
//		);
//		if ($new->noRes($sql, $charsocialclass)) { showtime($temp_time, ' Ajout des domaines de la classe sociale du personnage'); }


		foreach ($cnt->inventaire->armes as $arme) { $new->noRes('INSERT INTO %characters_weapons SET %%%fields ', array('characters_id' => $v['char_id'], 'weapons_id' => $arme->id)); }
		if (!empty($cnt->inventaire->armes)) { showtime($temp_time, ' Ajout des armes du personnage'); }

		foreach ($cnt->inventaire->armures as $armure) { $new->noRes('INSERT INTO %characters_armors SET %%%fields ', array('characters_id' => $v['char_id'], 'armors_id' => $armure->id)); }
		if (!empty($cnt->inventaire->armures)) { showtime($temp_time, ' Ajout des armures du personnage'); }

	//	showtime($temp_time, 'Structure manquante pour la table "'.$table.'"');
		foreach ($struct as $k => $s) {
			if (!array_key_exists($s['Field'], $datas) && $s['Field'] !== 'deleted') { echo $s['Field']."\n"; }
		}
	}
	usleep(250000);
}$tables_done[]=$table;showtime($temp_time, $charreq.' requêtes pour la table "'.$table.'"');
$nbreq += $charreq;
$tables_done[] = 'characters_disciplines';
$tables_done[] = 'characters_domains';
$tables_done[] = 'characters_armors';
$tables_done[] = 'characters_weapons';
$tables_done[] = 'characters_setbacks';
$tables_done[] = 'characters_avantages';
$tables_done[] = 'characters_flux';
//$tables_done[] = 'characters_social_class';
$tables_done[] = 'characters_ways';



//exit;








/****************************************************
*****************************************************
*******************FIN DE L'IMPORT*******************
*****************************************************
*****************************************************/
// showtime($temp_time, 'Fin de l\'import, <strong style="color: #88f;">'.$nbreq.'</strong> insertions effectuées');
showtime($temp_time, 'Fin de l\'import, '.$colors->getColoredString($nbreq, "green").' insertions effectuées');

showtime($temp_time, 'Reste à ajouter :');
print_r($to_add);

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
//$tables_done[] = 'char_disciplines'; $tables_err[] = 'char_disciplines';
//$tables_done[] = 'char_domains'; $tables_err[] = 'char_domains';
//$tables_done[] = 'char_ways'; $tables_err[] = 'char_ways';
//$tables_done[] = 'char_flux'; $tables_err[] = 'char_flux';
//$tables_done[] = 'char_avtgs'; $tables_err[] = 'char_avtgs';
//$tables_done[] = 'char_revers'; $tables_err[] = 'char_revers';
//$tables_done[] = 'disorder_ways'; $tables_err[] = 'disorder_ways';
//$tables_done[] = 'game_players'; $tables_err[] = 'game_players';
/*!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/






/*---------------------------------------------------------------------------------------
 -----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
---------------------------- TABLES À NE PAS FAIRE CAR MAPS -----------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------*/
$tables_done[] = 'events';
$tables_done[] = 'eventszones';
$tables_done[] = 'eventsroutes';
$tables_done[] = 'eventsroutestypes';
$tables_done[] = 'eventsmarkers';
$tables_done[] = 'eventsmarkerstypes';
$tables_done[] = 'eventsresources';
$tables_done[] = 'factions';
$tables_done[] = 'factions_events';
$tables_done[] = 'foes';
$tables_done[] = 'foes_events';
$tables_done[] = 'maps';
$tables_done[] = 'markers';
$tables_done[] = 'markerstypes';
$tables_done[] = 'npcs';
$tables_done[] = 'npcs_events';
$tables_done[] = 'resources';
$tables_done[] = 'resources_routes';
$tables_done[] = 'resources_routestypes';
$tables_done[] = 'routes';
$tables_done[] = 'routes_markers';
$tables_done[] = 'routestypes';
$tables_done[] = 'routestypes_events';
$tables_done[] = 'weather';
$tables_done[] = 'weather_events';
$tables_done[] = 'zones';


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


echo 'Tables à terminer :',"\n";
foreach ($new_tables as $t) {
	if (!in_array($t, $tables_done)) {
		echo "\n", $colors->getColoredString($t, "green");
	}
}

echo "\n",'Tables à refaire :',"\n";
foreach ($tables_err as $t) {
	echo "\n", $colors->getColoredString($t, "red");
}

showtime($temp_time, 'Finalisation');

echo "\n".'Temps d\'exécution : '.(microtime(true) - $time).' secondes';
echo "\n";