<?php

namespace EsterenMaps\MapsBundle\ImageManagement;

/**
 * This class stores the attributes of an identification made by the MapsTilesManager
 */
class ImageIdentification implements \ArrayAccess
{

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @var array
     */
    private $validProperties = [
        'xmax',
        'ymax',
        'tiles_max',
        'wmax',
        'hmax',
        'wmax_global',
        'hmax_global',
    ];

    /**
     * @param array $datas
     */
    public function __construct(array $datas = [])
    {
        $this->properties = array_merge(array_fill_keys($this->validProperties, null), $datas);
    }

    /**
     * @return int
     */
    public function getTilesX()
    {
        return $this->properties['xmax'];
    }

    /**
     * @return int
     */
    public function getTilesY()
    {
        return $this->properties['ymax'];
    }

    /**
     * @return int
     */
    public function getTiles()
    {
        return $this->properties['tiles_max'];
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return $this->properties['wmax'];
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return $this->properties['hmax'];
    }

    /**
     * @return float
     */
    public function getGlobalWidth()
    {
        return $this->properties['wmax_global'];
    }

    /**
     * @return float
     */
    public function getGlobalHeight()
    {
        return $this->properties['hmax_global'];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->properties);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->properties[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if ($this->offsetExists($offset)) {
            $this->properties[$offset] = $value;
        } else {
            throw new \RuntimeException(sprintf(
                'Undefined attribute %s in ImageIdentification',
                $offset
            ));
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->properties[$offset]);
        return $this;
    }
}
