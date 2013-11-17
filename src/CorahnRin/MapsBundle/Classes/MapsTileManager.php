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

    public function mapSourceName() {
        return ROOT.'/web/'.$this->map->getImage();
    }

    public function mapDestinationName($zoom, $x, $y) {
        $imgname = ROOT.'/app/cache/maps_img/'.$this->map->getNameSlug().'/'.$this->map->getNameSlug().'_'.$zoom.'_'.$x.'_'.$y.'.jpg';
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }
        return $imgname;
    }

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

    public function createTile($x, $y, $zoom, $dry_run = false) {

        if ($zoom > $this->map->getMaxZoom()) { throw new \RunTimeException('"zoom" value must be between 1 and '.$this->map->getMaxZoom().'.'); }

        $ratio = ( $zoom / $this->map->getMaxZoom() ) * 100;

        $identification = $this->identifyImage($zoom);

        if ($x < 0 || $x > $identification['xmax']) { throw new \RunTimeException('"x" value must be between 0 and '.$identification['xmax'].'.'); }
        if ($y < 0 || $y > $identification['ymax']) { throw new \RunTimeException('"y" value must be between 0 and '.$identification['ymax'].'.'); }

        $_x = $x*$this->img_size;
        $_y = $y*$this->img_size;
        $cmd = 'convert'.
            ' "'.$this->mapSourceName().'"'.
            ($ratio < 100 ? ' -resize '.$ratio.'%' : '').
            ' -background black'.//Le "surplus" sera noirs
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
}
