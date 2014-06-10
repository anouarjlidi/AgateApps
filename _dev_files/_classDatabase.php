<?php

/**
 * Created by PhpStorm.
 * User: Pierstoval
 * Date: 10/06/14
 * Time: 22:32
 */

class Database extends PDO
{
    public static $prefix;
    public $table = '';
    private $show_err = true;
    private $err_type = 'error';
    private $last_values;
    private $last_results;
    private $last_query;

    function __construct($p = '127.0.0.1', $q = 'root', $r = '', $s = 'mydb', $u = '', $w = 'mysql')
    {
        $y[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        self::$prefix = $u;
        $z = $w . ':host=' . $p . ';
dbname=' . $s . '';
        $this->initErr(true);
        try {
            parent::__construct($z, $q, $r, $y);
            $this->dbname = $s;
        } catch (Exception $d) {
            $this->showErr($d, null, null, true);
        }
        $this->noRes('SET NAMES "utf8"');
    }

    protected function initErr($aa = false, $bb = 'fatal')
    {
        $this->show_err = $aa == true ? true : false;
        if ($bb === 'warning') {
            $this->err_type = E_USER_WARNING;
        } elseif ($bb === 'fatal') {
            $this->err_type = E_USER_ERROR;
        } elseif ($bb === 'notice') {
            $this->err_type = E_USER_NOTICE;
        } else {
            $this->err_type = E_USER_WARNING;
        }
    }

    protected function showErr(Exception $d = null, $cc = null)
    {
//        $ff = is_object($d) ? $d->getTrace() : '';
        echo 'Une erreur MySQL est survenue...<br />' . "\n";
        pr(array('pdo_ex' => (is_object($d) ? $d->getMessage() : ''), 'qry' => $cc, 'datas' => $this->last_values /*,'trace'=>$ff*/));
        exit("\n" . 'ERREUR' . "\n");
    }

    public function noRes($cc, $gg = array())
    {
        $gg = (array)$gg;
        $cc = $this->buildReq($cc, $gg);
        $pp = $this->runReq($cc, $gg);
        if (is_object($pp) && $pp->rowCount() > 0) {
            $vv = $pp->rowCount();
        } elseif (is_array($pp)) {
            $vv = $pp;
        } else {
            $vv = false;
        }
        $this->last_results = $vv;
        if ($vv) {
            $pp->closeCursor();
        }
        return $vv ? true : false;
    }

    private function buildReq($cc, $gg = array())
    {
        if (strpos($cc, '[TABLE]') !== false) {
            $cc = str_replace('%[TABLE]', '[TABLE]', $cc);
            $cc = str_replace('[TABLE]', '%' . $this->table, $cc);
        }
        $cc = $this->sbuildReq($cc, $gg, $this->table);
        $this->last_query = $cc;
        $this->last_values = $gg;
        return $cc;
    }

    public static function sbuildReq($cc, $gg = array())
    {
        $gg = (array)$gg;
        if (strpos($cc, '%%%fields') !== false) {
            $hh = array();
            foreach ($gg as $ii => $jj) {
                $ii = str_replace(':', '', $ii);
                $hh[] = '%' . $ii . ' = :' . $ii;
            }
            $cc = str_replace('%%%fields', implode(', ', $hh), $cc);
        }
        if (strpos($cc, '%%%in') !== false) {
            if (empty($gg)) {
                $cc = str_replace('%%%in', '0', $cc);
            } else {
                $kk = implode(', ', array_fill(0, count($gg), '?'));
                $cc = str_replace('%%%in', $kk, $cc);
            }
        }
        $cc = preg_replace('#%%([a-zA-Z0-9_]+)#', ' `' . self::$prefix . '$1` ', $cc);
        $cc = preg_replace('#%([a-zA-Z0-9_]+)#', ' `$1` ', $cc);
        foreach ($gg as $mm => $nn) {
            if (!preg_match('#^:#isUu', $mm) && !is_numeric($mm)) {
                unset($gg[$mm]);
                $gg[':' . $mm] = $nn;
            }
        }
        $cc = str_replace("\n", ' ', $cc);
        $cc = str_replace("\r", '', $cc);
        $cc = str_replace("\t", '', $cc);
        $cc = preg_replace('#\s\s+#Uu', ' ', $cc);
        return $cc;
    }

    private function runReq($cc, $gg = array())
    {
        $gg = (array)$gg;
        try {
            $pp = $this->prepare($cc);
            $pp->execute($gg);
        } catch (Exception $d) {
            $this->showErr($d, $cc);
            exit;
        }
        return $pp;
    }

    public function req($cc, $gg = array())
    {
        $gg = (array)$gg;
        $cc = $this->buildReq($cc, $gg);
        $pp = $this->runReq($cc, $gg);
        if (is_object($pp) && $pp->rowCount() > 0) {
            $qq = $pp->fetchAll(PDO::FETCH_ASSOC);
            foreach ($qq as $rr => $ss) {
                foreach ($ss as $tt => $uu) {
                    if (is_numeric($uu)) {
                        $qq[$rr][$tt] = (int)$uu;
                    }
                    if (is_int($tt)) {
                        unset($qq[$rr][$tt]);
                    }
                }
            }
        } elseif (is_array($pp)) {
            $qq = $pp;
        } else {
            $qq = false;
        }
        $this->last_results = $qq;
        if (is_object($pp)) {
            $pp->closeCursor();
        }
        return $qq;
    }

    public function row($cc, $gg = array())
    {
        $gg = (array)$gg;
        $cc = $this->buildReq($cc, $gg);
        if (!preg_match('#LIMIT +[0-9]+( *, *[0-9]+)?#isU', $cc)) {
            $cc .= ' LIMIT 0,1';
        }
        $pp = $this->runReq($cc, $gg);
        if (is_object($pp) && $pp->rowCount() > 0) {
            $qq = $pp->fetch();
            foreach ($qq as $rr => $ss) {
                if (is_numeric($ss)) {
                    $qq[$rr] = (int)$ss;
                }
                if (is_int($rr)) {
                    unset($qq[$rr]);
                }
            }
        } elseif (is_array($pp)) {
            $qq = $pp;
        } else {
            $qq = false;
        }
        $this->last_results = $qq;
        if (is_object($pp)) {
            $pp->closeCursor();
        }
        return $qq;
    }

    protected function last_id()
    {
        $oo = 0;
        try {
            $oo = $this->lastInsertId();
            $oo = (int)$oo;
        } catch (Exception $d) {
            $this->showErr($d, '', $oo, true);
        }
        return $oo;
    }
}
