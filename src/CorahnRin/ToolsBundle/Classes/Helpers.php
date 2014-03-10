<?php

namespace CorahnRin\ToolsBundle\Classes;

/**
 * Class Helpers
 * Project corahn_rin
 *
 * @author Pierstoval
 * @version 1.0 08/03/2014
 */
class Helpers {

    ## Couleur des différents types de variables pour les fonctions p_dump et p_dumpTxt
    const PR_INTCOLOR = 'blue';
    const PR_FLOATCOLOR = 'darkblue';
    const PR_NUMSTRINGCOLOR = '#c0c';
    const PR_STRINGCOLOR = 'darkgreen';
    const PR_RESSCOLOR = '#aa0';
    const PR_NULLCOLOR = '#aaa';
    const PR_BOOLTRUECOLOR = '#0c0';
    const PR_BOOLFALSECOLOR = 'red';
    const PR_OBJECTCOLOR = 'pink';
    const PR_PADDINGLEFT = '25px';
    const PR_WIDTH = '';

    public static function json_encode($value, $options = 0, $depth = 512) {
        $options = $options | JSON_NUMERIC_CHECK;
        if (version_compare(PHP_VERSION, '5.4.0', '>')) {
           $options = $options | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;
        }

        return json_encode($value, $options, $depth);
    }

    /**
     * Utilisé par la fonction p_dump() pour formater le texte et le coloriser selon son type
     *
     * @param mixed $val La variable à tester
     * @return string contenant un formatage selon le typage
     * @author Pierstoval
     * @version 1.0 26/12/2012
     * @version 1.1 08/03/2014 Adaptation à une classe objet
     */
    private static function p_dumpTxt($val = null) {
        $final = '';
        if (is_int($val)) {
            $final .= '<small><em>entier</em></small> <span style="color:'.self::PR_INTCOLOR.';">' . $val . '</span>';
        } elseif (is_float($val)) {
            $final .= '<small><em>décimal</em></small> <span style="color:'.self::PR_FLOATCOLOR.';">' . $val . '</span>';
        } elseif (is_numeric($val)) {
            $final .= '<small><em>chaîne numérique</em> (' . strlen($val) . ')</small> <span style="color:'.self::PR_NUMSTRINGCOLOR.';">\'' . $val . '\'</span>';
        } elseif (is_string($val)) {
            $final .= '<small><em>chaîne</em> (' . strlen($val) . ')</small> <span style="color:'.self::PR_STRINGCOLOR.';">\'' . htmlspecialchars($val) . '\'</span>';
        } elseif (is_resource($val)) {
            $final .= '<small><em>ressource</em></small> <span style="color:'.self::PR_RESSCOLOR.';">' . get_resource_type($val) . '</span>';
        } elseif (is_null($val)) {
            $final .= '<span style="color: '.self::PR_NULLCOLOR.';">null</span>';
        } elseif (is_bool($val)) {
            $final .= '<span style="color: '.($val === true ? self::PR_BOOLTRUECOLOR : self::PR_BOOLFALSECOLOR).';">'.($val === true ? 'true' : 'false').'</span>';
        } elseif (is_object($val)) {
            ob_start();
            var_dump($val);
            $final .= ob_get_clean();
        } elseif (is_array($val)) {
            $final .= '<em>tableau</em> {' . p_dump($val) . '}';
        } else {
            $final .= $val;
        }
        return $final;
    }

    /**
     * Alias de la fonction var_dump, cette fonction permet un affichage plus sympathique des dump de variables
     *
     * @param mixed $val La variable à tester
     * @return string contenant un dump plus agréable de la variable entrée en paramètre
     * @author Pierstoval 26/12/2012
     */
    public static function pr($param, $return = false) {

        if ($lay === 'default') {
            $final = '<div class="p_dump" style="margin: 0 auto;'.(self::PR_WIDTH ? 'max-width: '.self::PR_WIDTH.';' : '').' min-height: 20px;">';
            $final .= '<p style="cursor: pointer; float: right; padding-left: 200px; margin: 0;"
            onclick="$(this).next(\'div\').slideToggle(400);"><span class="icon-chevron-down"></span></p>';
            $final .= '<div>';
        } else {
            $final = '<div><div>';
        }
        if (!is_array($param)) {
            ## Considère tout ce qui n'est pas array, affichage simple
            $final .= '<div style="margin-left: 0;">';
            $final .= self::p_dumpTxt($param, true);
            $final .= '</div>';
        } else {
            ## Considère les array, et fais une boucle récursive
            $final .= '<div style="padding-left: '.self::PR_PADDINGLEFT.';">';
            foreach ($param as $key => $val) {
                $final .= '<div>';
                if (is_int($key)) {
                    $final .= '<span style="color:'.self::PR_INTCOLOR.';">' . $key . '</span>';
                } else {
                    $final .= '<span style="color:'.self::PR_STRINGCOLOR.';">\'' . $key . '\'</span>';
                }
                $final .= ' => ';
                $final .= self::p_dumpTxt($val, true);
                $final .= '</div>';
            }
            $final .= '</div>';
        }
        $final .= '</div></div>';
        if (false == $return) {
            echo $final;
        } else {
            return $final;
        }
    }
}
