<?php
namespace CorahnRinTools;

class Translate {
    
    public static $instance;
	private $file = '';
	private $file_log = '';
	private $words = array();
	private $insert_count = 0;

	function __construct() {
		$this->file = CORAHNRIN_TOOLS.DS.'translation'.DS.'words_'.P_LANG.'.php';
		$this->file_log = CORAHNRIN_TOOLS.DS.'translation'.DS.'words_'.P_LANG.'.log';
		if (file_exists($this->file)) {
			$cnt = file_get_contents($this->file);
			$cnt = json_decode($cnt, true);
			if ($cnt) {
				$this->words = $cnt;
			}
		} else {
            mkdir(dirname($this->file), 0777, true);
            mkdir(dirname($this->file_log), 0777, true);
            touch($this->file);
            touch($this->file_log);
            chmod($$this->file, 0777);
            chmod($$this->file_log, 0777);
			$this->words = array();
		}
    }
    
    function __destruct() {
        $this->save_all_words();
    }

	/**
	 * Cette fonction initialise la classe et crée les variables disposant du contenu
     * Les fichiers de sauvegarde sont récupérés.
     * S'ils n'existent pas, on crée le chemin et on crée les fichiers avec un chmod de 0777
	 */
	public static function init() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
	}

	/**
	 * Sauvegarde des informations dans le fichier log de traduction
	 *
	 * @param unknown $params
	 */
	private function log($type, $arg1, $arg2 = null, $arg3 = null) {
		global $global_time;
		$data = array(
			'type'=>$type,
			'date'=>date(DATE_RFC822),
			'ip'=>$_SERVER['REMOTE_ADDR'],
			'user_id'=>Users::$id,
			'exectime'=>$global_time,
		);
		$save = true;
		if ($type === 'new_word') {
			$data['contents'] = array('word'=>$arg1);
		} elseif ($type === 'new_translation') {
			$data['contents'] = array('word'=>$arg1,'translation'=>$arg2);
		} elseif ($type === 'update_translation') {
			$data['contents'] = array('word'=>$arg1,'translation'=>$arg2,'old_translation'=>$arg3);
		} else {
			$save = false;
		}

		if ($save === true) {
			$data = json_encode($data, P_JSON_ENCODE);
			file_put_contents($this->file_log, $data, FILE_APPEND);
		}
	}
	
	/**
	 * Cette fonction sert à traduire le texte. Si le mot n'est pas traduit, on l'ajoute à la liste pour qu'il le soit plus tard.
	 *
	 * @param string $txt Le texte à traduire
	 * @param boolean $return Si false, on fait un echo du texte. Si true, on le retourne.
	 * @param array $params Une liste de paramètres à ne pas traduire, pour éviter d'avoir à traduire plusieurs fois le même texte
	 * @return mixed Le texte traduit si $return == true, sinon true après echo, sinon false
	 */
	public function _translate($txt, $return = false, $params = array()) {
		$txt = $this->clean_word($txt);

		if (!$txt) { return ''; }

		if (count($params)) {
			ksort($params);
			$params_string = $params_numeric = array();
			//Reformatage des deux tableaux (pour palier aux erreurs, forcer les accolades sur la clé, et réinitialiser les valeurs numériques)
			foreach ($params as $k => $v) {
				if (is_string($k)) {
					$k = preg_replace('~\{|\}~isUu', '', $k);
					$k = '{'.$k.'}';
					$params_string[$k] = $v;
				} elseif (is_numeric($k)) {
					$params_numeric[] = $v;
				}
			}

			//Changement des chaînes
			foreach ($params_string as $k => $v) {
				$txt = str_replace($k, $v, $txt);
			}
			foreach ($params_numeric as $v) {
				$txt = preg_replace('~\{\}~U', $v, $txt, 1);
			}
		}

		if (P_LANG === 'fr') {//Par défaut si le site est en français, on n'a rien à traduire
			if ($return === false) { echo $txt; return; } else { return $txt; }
		}

		if (!array_key_exists($txt, $this->words)) {
			$this->words[$txt] = '';
			$this->log('new_word', $txt);
			$this->insert_count ++;
		} elseif ($this->clean_word($this->words[$txt])) {
			$txt = clean_word($this->words[$txt]);
		}

		if ($return === false) {
			echo $txt;
			return;
		} else {
			return $txt;
		}
	}

	/**
	 * Cette fonction sert à traduire le texte. Si le mot n'est pas traduit, on l'ajoute à la liste pour qu'il le soit plus tard.
	 *
	 * @param string $txt Le texte à traduire
	 * @param boolean $return Si false, on fait un echo du texte. Si true, on le retourne.
	 * @param array $params Une liste de paramètres à ne pas traduire, pour éviter d'avoir à traduire plusieurs fois le même texte
	 * @return mixed Le texte traduit si $return == true, sinon true après echo, sinon false
	 */
	public static function translate($txt, $return = false, $params = array()) {
		if (!self::$instance) { self::init(); }
		return self::$instance->_translate($txt, $return, $params);
	}

	/**
	 * Cette fonction sert à ajouter ou éditer un mot traduit
	 *
	 * @param string $word Le mot ou l'expression à traduire
	 * @param string $trans La traduction
	 * @return int|boolean L'état du mot. 1 s'il a été inséré, 2 si le mot a été réenregistré, false sinon
	 */
	public function write_translation($word, $trans) {

		$word = $this->clean_word($word);
		$trans = $this->clean_word($trans);

		$words = $this->words;

		$ret = false;

		if ($word && $trans) {
			if (!array_key_exists($word, $words)) {
				$ret = 1;
				$this->log('new_translation', $word, $trans);
			} else {
				$ret = 2;
				$this->log('update_translation', $word, $trans);
			}
			$this->words[$word] = $trans;
			$this->insert_count ++;
		}

		return $ret;
	}

	/**
	 * Cette fonction sert à "nettoyer" un mot ou une expression
	 *
	 * @param string $word Le mot ou l'expression à traduire
	 * @return string Le mot "nettoyé"
	 */
	private function clean_word($word) {
		$word = preg_replace('#\s\s+#sUu', ' ', $word);
		$word = str_replace('’', "'", $word);
		$word = str_replace('\\\'', "'", $word);
		$word = str_replace('★', '&#9733;', $word);
		$word = trim($word);
		return $word;
	}

	/**
	 * Cette fonction sert à écrire les traductions dans le fichier dédié
	 *
	 * @return boolean Résultat de l'opération
	 */
	private function save_all_words() {
		if (P_LANG === 'fr') { return true; }
		$words_for_translation = $this->words;
		ksort($words_for_translation);
		$words_for_translation = json_encode($words_for_translation, P_JSON_ENCODE);

		if ($this->insert_count > 0) {
			return file_put_contents($this->file, $words_for_translation);
		}
	}
}