<?php

namespace EsterenMaps\MapsBundle\Services;

use EsterenMaps\MapsBundle\Entity\Maps;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class MapsTilesManager
 *
 * @package EsterenMaps\MapsBundle\Services
 */
class MapsTilesManager {

    /**
     * @var Maps
     */
    private $map;
    private $tile_size;
    private $img_width;
    private $img_height;
    private $identifications = array();
    private $imgname = '';
    private $magickPath = '';

    function __construct ($output_directory, $tile_size, $magick_binaries_path, KernelInterface $kernel) {
        $this->tile_size = $tile_size;
        $output_directory = trim($output_directory, '\\/');
        $this->magickPath = trim($magick_binaries_path).DIRECTORY_SEPARATOR;
        if (strpos($output_directory, '@') === 0) {
            $this->output_directory = $kernel->locateResource($output_directory);
        } else {
            $this->output_directory = $output_directory;
        }
    }

    public function setMap (Maps $map) {
        $this->map = $map;
        if (!file_exists($this->map->getImage())) {
            throw new \Exception('Map image could not be found.');
        }
        return $this;
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
                $cmd = $this->magickPath.'identify -format "%wx%h" "'.$this->map->getImage().'" 2>&1';
                $size = shell_exec($cmd);
                if (!$size || !preg_match('#^[0-9]+x[0-9]+$#', $size)) {
                    $size = trim($size);
                    $msg = 'Error while retrieving map dimensions. Command returned error:'."\n\t".str_replace("\n","\n\t", $size);
                    $msg = trim($msg);
                    if (strpos($msg, 'no decode delegate') !== false) {
                        $msg .= "\n".'Do you have installed necessary delegates for ImageMagick ?';
                    }
                    throw new \RunTimeException($msg);
                }
                list($w, $h) = explode('x',$size);
                $this->img_width = $w;
                $this->img_height = $h;
            }

            // Calcul des ratios et du nombre maximum de vignettes
            $crop_unit = pow(2, $this->map->getMaxZoom() - $zoom) * $this->tile_size;

            $max_tiles_x = ceil($this->img_width / $crop_unit) - 1;
            $max_tiles_y = ceil($this->img_height / $crop_unit) - 1;

            $max_width = $max_tiles_x * $this->tile_size;
            $max_height = $max_tiles_y * $this->tile_size;

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
     * @param integer $zoom
     * @param boolean $debug
     */
    public function generateTiles($zoom, $debug = false) {
        $max = $this->map->getMaxZoom();

        $ratio = 1 / ( pow(2, $max - $zoom) ) * 100;

        $output_scheme = $this->output_directory.'/temp_tiles/'.$this->map->getId().'/'.$zoom.'.jpg';
        $output_final = $this->output_directory.'/'.$this->map->getId().'/'.$zoom.'/{x}/{y}.jpg';

        if (!is_dir(dirname($output_scheme))) {
            mkdir(dirname($output_scheme), 0775, true);
        }

        // Supprime tout fichier existant
        $existing_files = glob(dirname($output_scheme).'/*');
        foreach ($existing_files as $file) {
            unlink($file);
        }

        $this->identifyImage($zoom);

        $w = $this->img_width;
        $h = $this->img_height;

        if ($w >= $h) {
            $h = $w;
        } else {
            $w = $h;
        }

        $cmd =
            $this->magickPath.'convert "'.$this->map->getImage(DIRECTORY_SEPARATOR).'"' .
            ' -background #000000'.
            ' -extent '.$w.'x'.$h.
            ' -resize '.$ratio.'% ' .
            ' -crop '.$this->tile_size.'x'.$this->tile_size .
            ' -background #000000'.
            ' -extent '.$this->tile_size.'x'.$this->tile_size .
            ' -thumbnail '.$this->tile_size.'x'.$this->tile_size .
            ' "'.$output_scheme.'"' .
            ' 2>&1'
        ;

        $command_result = shell_exec($cmd);

        if ($command_result) {
            $command_result = trim($command_result);
            $msg = 'Error while processing conversion. Command returned error:'."\n\t".str_replace("\n","\n\t", $command_result);
            $msg = trim($msg);
            if ($debug) {
                $msg .= "\n".'Executed command : '."\n\t".$cmd;
            }
            throw new \RunTimeException($msg);
        }

        $existing_files = glob(dirname($output_scheme).'/*');

        sort($existing_files, SORT_NATURAL | SORT_FLAG_CASE);
        $existing_files = array_values($existing_files);

        $modulo = sqrt(count($existing_files));

        foreach ($existing_files as $i => $file) {
            $x = floor( $i / $modulo );
            $y = $i % $modulo;
            $filename = str_replace('{x}', $x, $output_final);
            $filename = str_replace('{y}', $y, $filename);

            if  (!is_dir(dirname($filename))) {
                mkdir(dirname($filename), 0775, true);
            }

            rename($file, $filename);

        }

        // Supprime tout fichier existant
        $existing_files = glob(dirname($output_scheme).'/*');
        foreach ($existing_files as $file) {
            unlink($file);
        }
    }

    /**
     * Crée une commande de découpage de l'image de la carte en utilisant ImageMagick
     * Si "dry_run" est passé à "true", renvoie uniquement la commande
     * Sinon, exécute la commande via shell_exec() et retourne le résultat
     * @param integer $x
     * @param integer $y
     * @param integer $zoom
     * @param bool|int $dry_run
     * @param bool $throw_error
     * @throws \RunTimeException
     * @return string
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

        $crop_unit = pow(2, $this->map->getMaxZoom() - $zoom) * $this->tile_size;

        $_x = $x * $crop_unit;
        $_y = $y * $crop_unit;

        $cmd = $this->magickPath.'convert'.
            ' "'.$this->mapSourceName().'"'.
            ' -background black'.//Le "surplus" sera noir
            ' -extent '.$identification['wmax_global'].'x'.$identification['hmax_global'].
            ' -crop '.$crop_unit.'x'.$crop_unit.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -resize '.$this->tile_size.'x'.$this->tile_size.'^'.//Redimensionne à la taille paramétrée
            ' -extent '.$this->tile_size.'x'.$this->tile_size.//Et étend les éventuels pixels manquants, pour les bordures
            ' -thumbnail '.$this->tile_size.'x'.$this->tile_size.//Crée un thumbnail en métadonnée, pour alléger le poids
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
     * @param bool $dry_run
     * @return string
     */
    public function createImage($zoom, $x, $y, $width, $height, $dry_run = false) {
        $identification = $this->identifyImage($zoom);
        $ratio = ( $zoom / $this->map->getMaxZoom() ) * 100;
        $imgname = $this->mapDestinationName($zoom, $x, $y, $width, $height);
        $this->imgname = $imgname;
        if (!is_dir(dirname($imgname))) {
            mkdir(dirname($imgname), 0777, true);
        }
        $cmd = $this->magickPath.'convert'.
            ' "'.$this->mapSourceName().'"'.
            ' -background black'.//Le "surplus" sera noir
            ' -crop '.$crop_unit.'x'.$crop_unit.'+'.$_x.'+'.$_y.//Découpe l'image selon la taille demandée dans les paramètres
            ' -resize '.$width.'x'.$height.'^'.//Redimensionne à la taille paramétrée
            ' -extent '.$width.'x'.$height.''.//Et étend les éventuels pixels manquants, pour les bordures
            ' -thumbnail '.$width.'x'.$width.//Crée un thumbnail en métadonnée, pour alléger le poids
            ' -quality 100'.//Une faible qualité réduira le poids des images
            ' "'.$imgname.'"'
        ;
        $cmd = $this->magickPath.'convert'.
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
