<?php

namespace EsterenMaps\MapsBundle\Services;

use EsterenMaps\MapsBundle\Entity\Maps;
use EsterenMaps\MapsBundle\ImageManagement\ImageIdentification;
use Orbitale\Component\ImageMagick\Command;
use Orbitale\Component\ImageMagick\ReferenceClasses\Geometry;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class MapsTilesManager
 *
 * @package EsterenMaps\MapsBundle\Services
 */
class MapsTilesManager
{

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @var string
     */
    private $webDir;

    /**
     * @var Maps
     */
    private $map;

    /**
     * @var ImageIdentification[]
     */
    private $identifications = array();

    /**
     * @var int
     */
    private $tile_size;

    /**
     * @var int
     */
    private $img_width;

    /**
     * @var int
     */
    private $img_height;

    /**
     * @var string
     */
    private $magickPath = '';

    /**
     * @var bool
     */
    private $debug;

    function __construct ($outputDirectory, $tile_size, $magick_binaries_path, KernelInterface $kernel) {
        $this->tile_size = $tile_size;
        $outputDirectory = rtrim($outputDirectory, '\\/');
        $this->magickPath = rtrim($magick_binaries_path, '\\/').DIRECTORY_SEPARATOR;
        if (strpos($outputDirectory, '@') === 0) {
            $this->outputDirectory = $kernel->locateResource($outputDirectory);
        } else {
            $this->outputDirectory = $outputDirectory;
        }
        $this->webDir = $kernel->getRootDir().'/../web';
        $this->debug = $kernel->isDebug();
    }

    /**
     * @return string
     */
    public function getOutputDirectory()
    {
        return $this->outputDirectory;
    }

    /**
     * @param Maps $map
     *
     * @return $this
     * @throws \Exception
     */
    public function setMap (Maps $map) {
        $this->map = $map;
        if (!file_exists($this->map->getImage())) {
            throw new \Exception('Map image could not be found : '.$map->getImage());
        }
        return $this;
    }

    /**
     * Identifie les caractéristiques de la carte si ce n'est pas déjà fait
     * Renvoie l'identification demandée en fonction du zoom
     * Renvoie une exception si l'identification par ImageMagick ne fonctionne pas
     * @param integer $zoom
     * @return ImageIdentification|ImageIdentification[]
     * @throws \RunTimeException
     */
    public function identifyImage($zoom = null)
    {
        if (!$this->img_width || !$this->img_height) {
            // Détermine la taille de l'image initiale une fois et place les attributs dans l'objet
            $size = getimagesize($this->webDir.'/'.$this->map->getImage());
            if (!$size || !isset($size[0]) || !isset($size[1])) {
                throw new \RunTimeException('Error while retrieving map dimensions');
            }
            list($w, $h) = $size;
            $this->img_width = $w;
            $this->img_height = $h;
        }

        if (null === $zoom) {
            return $this->identifications;
        }

        if (!isset($this->identifications[$zoom])) {

            // Calcul des ratios et du nombre maximum de vignettes
            $crop_unit = pow(2, $this->map->getMaxZoom() - $zoom) * $this->tile_size;

            $max_tiles_x = ceil($this->img_width / $crop_unit) - 1;
            $max_tiles_y = ceil($this->img_height / $crop_unit) - 1;

            $max_width = $max_tiles_x * $this->tile_size;
            $max_height = $max_tiles_y * $this->tile_size;

            $max_width_global = $crop_unit * ( $max_tiles_x + 1 );
            $max_height_global = $crop_unit * ( $max_tiles_y + 1 );

            $this->identifications[$zoom] = new ImageIdentification(array(
                'xmax' => $max_tiles_x,
                'ymax' => $max_tiles_y,
                'tiles_max' => $max_tiles_x * $max_tiles_y,
                'wmax' => $max_width,
                'hmax' => $max_height,
                'wmax_global' => $max_width_global,
                'hmax_global' => $max_height_global,
            ));
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

        $output_scheme = $this->outputDirectory.'/temp_tiles/'.$this->map->getId().'/'.$zoom.'.jpg';
        $output_final = $this->outputDirectory.'/'.$this->map->getId().'/'.$zoom.'/{x}/{y}.jpg';

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
            $this->magickPath.'convert "'.$this->map->getImage().'"' .
            ' -background "#000000"'.
            ' -extent '.$w.'x'.$h.
            ' -resize "'.$ratio.'%" ' .
            ' -crop '.$this->tile_size.'x'.$this->tile_size .
            ' -background "#000000"'.
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
     * Crée une image à partir de l'image principale et renvoie le nom du fichier temporaire
     * TOUTES LES DIMENSIONS DOIVENT ÊTRE EN PIXELS !
     *
     * @param integer $ratio
     * @param integer $x
     * @param integer $y
     * @param integer $width
     * @param integer $height
     * @param bool    $dry_run
     *
     * @return string The output file name
     * @throws \Exception
     */
    public function createImage($ratio, $x, $y, $width, $height, $dry_run = false)
    {
        if ($ratio <= 0 || null === $ratio) {
            $ratio = 100;
        }
        $this->identifyImage();

        $maxWidth = $this->img_width;
        $maxHeight = $this->img_height;
        $errMsg = '"%s" + "%s" values exceed image size which is %dx%d';

        if (($ratio*$width/100) + $x >= $maxWidth) {
            throw new \Exception(sprintf($errMsg, 'width', 'x', $maxWidth, $maxHeight));
        }
        if (($ratio*$height/100) + $y >= $maxHeight) {
            throw new \Exception(sprintf($errMsg, 'height', 'y', $maxWidth, $maxHeight));
        }

        $imgOutput = $this->mapDestinationName($ratio, $x, $y, $width, $height);

        if (file_exists($imgOutput) && !$this->debug) {
            return $imgOutput;
        }

        if (!is_dir(dirname($imgOutput))) {
            mkdir(dirname($imgOutput), 0777, true);
        }

        $command = new Command($this->magickPath);

        $imgSource = $this->webDir.'/'.$this->map->getImage();

        $command
            ->convert($imgSource)
            ->background('black')
            ->crop(new Geometry(null, null, $x, $y))
            ->resize($ratio.'%')
            ->extent(new Geometry($width, $height, null, null, Geometry::RATIO_MIN))
            ->thumbnail(new Geometry($width, $height))
            ->quality(95)
            ->file($imgOutput, false)
        ;

        if ($dry_run === false) {
            $response = $command->run($this->debug ? Command::RUN_DEBUG : Command::RUN_NORMAL);
            if ($response->hasFailed() || !file_exists($imgOutput)) {
                throw new \RuntimeException("ImageMagick error.\n".$response->getContent(true));
            }
            return $imgOutput;
        }
        return $command->getCommand();
    }

    private function mapDestinationName($ratio, $x, $y, $width, $height)
    {
        return $this->outputDirectory.'/'.$this->map->getId().'/custom/'.$this->map->getNameSlug().'_'.$ratio.'_'.$x.'_'.$y.'_'.$width.'_'.$height.'.jpg';
    }
}
