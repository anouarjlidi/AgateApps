<?php

namespace EsterenMaps\MapsBundle\Classes;

use EsterenMaps\MapsBundle\Entity\Maps;

class MapsTileManager {

    private $map;
    private $img_size;
    private $img_width;
    private $img_height;
    private $identifications = array();
    private $imgname = '';

    function __construct (Maps $map, $img_size) {
        $this->map = $map;
        $this->img_size = $img_size;
    }

    public function getImgName() { return $this->imgname; }

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
            $imgname = ROOT.'/app/cache/maps_img/'.$this->map->getNameSlug().'/custom/'.$this->map->getNameSlug().'_'.$zoom.'_'.$x.'_'.$y.'_'.$width.'_'.$height.'.jpg';
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
            $crop_unit = pow(2, $this->map->getMaxZoom() - $zoom) * $this->img_size;

            $max_tiles_x = ceil($this->img_width / $crop_unit) - 1;
            $max_tiles_y = ceil($this->img_height / $crop_unit) - 1;

            $max_width = $max_tiles_x * $this->img_size;
            $max_height = $max_tiles_y * $this->img_size;

            $max_width_global = $crop_unit * ( $max_tiles_x + 1 );
            $max_height_global = $crop_unit * ( $max_tiles_y + 1 );

            $this->identifications[$zoom] = array(
                'xmax' => $max_tiles_x,
                'ymax' => $max_tiles_y,
                'tiles_max' => $max_tiles_x * $max_tiles_y,
                'wmax' => $max_width,
                'hmax' => $max_height,
                'wmax_global' => $max_width_global,
                'hmax_global' => $max_height_global,
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
    public function createTile($x, $y, $zoom, $dry_run = false, $throw_error = true) {

        if ($zoom > $this->map->getMaxZoom() || $zoom < 0) { throw new \RunTimeException('"zoom" value must be between 0 and '.$this->map->getMaxZoom().'.'); }

        $identification = $this->identifyImage($zoom);

        if ($x < 0 || $x > $identification['xmax']) {
            if ($throw_error) {
                throw new \RunTimeException('"x" value must be between 0 and '.$identification['xmax'].'.');
            } else {
                return null;
            }
        }
        if ($y < 0 || $y > $identification['ymax']) {
            if ($throw_error) {
                throw new \RunTimeException('"y" value must be between 0 and '.$identification['ymax'].'.');
            } else {
                return null;
            }
        }

        $imgname = $this->mapDestinationName($zoom, $x, $y);
        $this->imgname = $imgname;
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }

        $crop_unit = pow(2, $this->map->getMaxZoom() - $zoom) * $this->img_size;

        $_x = $x * $crop_unit;
        $_y = $y * $crop_unit;

        $cmd = 'convert'.
            ' "'.$this->mapSourceName().'"'.
            ' -background black'.//Le "surplus" sera noir
            ' -extent '.$identification['wmax_global'].'x'.$identification['hmax_global'].
            ' -crop '.$crop_unit.'x'.$crop_unit.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -resize '.$this->img_size.'x'.$this->img_size.'^'.//Redimensionne à la taille paramétrée
            ' -extent '.$this->img_size.'x'.$this->img_size.//Et étend les éventuels pixels manquants, pour les bordures
            ' -thumbnail '.$this->img_size.'x'.$this->img_size.//Crée un thumbnail en métadonnée, pour alléger le poids
            ' -quality 95'.//Une faible qualité réduira le poids des images
            ' "'.$this->mapDestinationName($zoom, $x, $y).'"'
        ;
//echo"\r\n".$cmd."\r\n";
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
        $this->imgname = $imgname;
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }
        $cmd = 'convert'.
            ' "'.$this->mapSourceName().'"'.
            ' -background black'.//Le "surplus" sera noir
            ' -crop '.$crop_unit.'x'.$crop_unit.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -resize '.$width.'x'.$height.'^'.//Redimensionne à la taille paramétrée
            ' -extent '.$width.'x'.$height.''.//Et étend les éventuels pixels manquants, pour les bordures
            ' -thumbnail '.$width.'x'.$width.//Crée un thumbnail en métadonnée, pour alléger le poids
            ' -quality 100'.//Une faible qualité réduira le poids des images
            ' "'.$imgname.'"'
        ;
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
