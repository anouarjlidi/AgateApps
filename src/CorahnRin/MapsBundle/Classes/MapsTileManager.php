<?php

namespace CorahnRin\MapsBundle\Classes;

use CorahnRin\MapsBundle\Entity\Maps;

class MapsTileManager {

    private $map;
    private $img_size;
    private $img_width;
    private $img_height;
    private $identifications = array();

    function __construct (Maps $map, $img_size) {
        $this->map = $map;
        $this->img_size = $img_size;
    }

    /**
     * Renvoie le fichier source de la map demandée
     * @return string
     */
    public function mapSourceName() {
        return ROOT.'/web/'.$this->map->getImage();
    }

    /**
     * Renvoie le nom du fichier de la tuile demandée par son zoom et sa position en X et Y
     * @param integer $zoom
     * @param integer $x
     * @param integer $y
     * @return string
     */
    public function mapDestinationName($zoom, $x, $y, $width = null, $height = null) {
        if ($width === null || $height === null) {
            $imgname = ROOT.'/app/cache/maps_img/'.$this->map->getNameSlug().'/'.$this->map->getNameSlug().'_'.$zoom.'_'.$x.'_'.$y.'.jpg';
        } else {
            $imgname = ROOT.'/app/cache/maps_img/'.$this->map->getNameSlug().'/custom/'.$this->map->getNameSlug().'/_'.$zoom.'_'.$x.'_'.$y.'_'.$width.'_'.$height.'.jpg';
        }
        return $imgname;
    }

    /**
     * Identifie les caractéristiques de la carte si ce n'est pas déjà fait
     * Renvoie l'identification demandée en fonction du zoom
     * Renvoie une exception si l'identification par ImageMagick ne fonctionne pas
     * @param integer $zoom
     * @return array
     * @throws \RunTimeException
     */
    public function identifyImage($zoom) {

        if (!isset($this->identifications[$zoom])) {
            if (!$this->img_width || !$this->img_height) {
                // Détermine la taille de l'image initiale une fois et place les attributs dans l'objet
                $cmd = 'identify -format "%wx%h" "'.$this->mapSourceName().'"';
                $size = shell_exec($cmd);
                if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
                    throw new \RunTimeException('Error while retrieving map dimensions.');
                }
                list($w, $h) = explode('x',$size);
                $this->img_width = $w;
                $this->img_height = $h;
            }

            // Calcul des ratios et du nombre maximum de vignettes
            $ratio = $zoom / $this->map->getMaxZoom();
            $_w = (int) $this->img_width * $ratio;
            $_h = (int) $this->img_height * $ratio;
            $xmax = $_w / $this->img_size;
            $ymax = $_h / $this->img_size;
            if ((int)$xmax < $xmax) { $xmax = ((int) $xmax) + 1; }
            if ((int)$ymax < $ymax) { $ymax = ((int) $ymax) + 1; }

            $wmax = $xmax * $this->img_size;
            $hmax = $ymax * $this->img_size;

            $this->identifications[$zoom] = array(
                'xmax' => $xmax,
                'ymax' => $ymax,
                'tiles_max' => $xmax * $ymax,
                'wmax' => $wmax,
                'hmax' => $hmax,
                'ratio' => $ratio,
            );
        }

        return $this->identifications[$zoom];
    }

    /**
     * Crée une commande de découpage de l'image de la carte en utilisant ImageMagick
     * Si "dry_run" est passé à "true", renvoie uniquement la commande
     * Sinon, exécute la commande via shell_exec() et retourne le résultat
     * @param integer $x
     * @param integer $y
     * @param integer $zoom
     * @param integer $dry_run
     * @return string
     * @throws \RunTimeException
     */
    public function createTile($x, $y, $zoom, $dry_run = false) {

        if ($zoom > $this->map->getMaxZoom()) { throw new \RunTimeException('"zoom" value must be between 1 and '.$this->map->getMaxZoom().'.'); }

        $ratio = ( $zoom / $this->map->getMaxZoom() ) * 100;

        $identification = $this->identifyImage($zoom);

        if ($x < 0 || $x > $identification['xmax']) { throw new \RunTimeException('"x" value must be between 0 and '.$identification['xmax'].'.'); }
        if ($y < 0 || $y > $identification['ymax']) { throw new \RunTimeException('"y" value must be between 0 and '.$identification['ymax'].'.'); }

        $imgname = $this->mapDestinationName($zoom, $x, $y);
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }

        $_x = $x*$this->img_size;
        $_y = $y*$this->img_size;
        $cmd = 'convert'.
            ' "'.$this->mapSourceName().'"'.
            ($ratio < 100 ? ' -resize '.$ratio.'%' : '').
            ' -background black'.//Le "surplus" sera noir
            ' -extent '.$identification['wmax'].'x'.$identification['hmax'].'^'.//Redimensionne aux valeurs "width" et "height" maximales dépendant du zoom
            ' -crop '.$this->img_size.'x'.$this->img_size.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -extent '.$this->img_size.'x'.$this->img_size.'^'.//Et étend les éventuels pixels en trop ou en moins
            ' -quality 95'.//Une faible qualité réduira le poids des images
            ' -thumbnail '.$this->img_size.'x'.$this->img_size.
            ' "'.$this->mapDestinationName($zoom, $x, $y).'"'
        ;

        if ($dry_run === false) {
            return shell_exec($cmd);
        }
        return $cmd;
    }
    
    /**
     * Crée une image à partir de l'image principale et renvoie le nom du fichier temporaire
     * TOUTES LES DIMENSIONS DOIVENT ÊTRE EN PIXELS !
     * @param integer $zoom
     * @param integer $x
     * @param integer $y
     * @param integer $width
     * @param integer $height
     */
    public function createImage($zoom, $x, $y, $width, $height, $dry_run = false) {
        $identification = $this->identifyImage($zoom);
        $ratio = ( $zoom / $this->map->getMaxZoom() ) * 100;
        $imgname = $this->mapDestinationName($zoom, $x, $y, $width, $height);
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }
        $cmd = 'convert'.
            ' "'.$this->mapSourceName().'"'.
            ($ratio < 100 ? ' -resize '.$ratio.'%' : '').
            ' -background black'.//Le "surplus" sera noir
            ' -extent '.$identification['wmax'].'x'.$identification['hmax'].'^'.//Redimensionne aux valeurs "width" et "height" maximales dépendant du zoom
            ' -crop '.$width.'x'.$height.'+'.$x.'+'.$y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -extent '.$width.'x'.$height.'^'.//Et étend les éventuels pixels en trop ou en moins
            ' -quality 95'.//Une faible qualité réduira le poids des images
            ' -thumbnail '.$width.'x'.$height.
            ' "'.$imgname.'"'
        ;

        if ($dry_run === false) {
            return shell_exec($cmd);
        }
        return $cmd;
    }
}
