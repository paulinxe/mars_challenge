<?php

namespace src;

class Grid
{
    private $upperX;
    private $upperY;

    /**
     * @param string $dimensions Space separated dimensions
     */
    function __construct($dimensions)
    {
        $dimensions = explode(' ', $dimensions);
        if (count($dimensions) !== 2) {
            throw new \InvalidArgumentException('Grid dimensions are invalid');
        }

        $this->upperX = intval($dimensions[0]);
        $this->upperY = intval($dimensions[1]);

        if ($this->upperX < 1 || $this->upperY < 1) {
            throw new \InvalidArgumentException('Grid dimensions are invalid');
        }
    }

    /**
     * @return integer
     */
    public function getUpperX()
    {
        return $this->upperX;
    }

    /**
     * @return integer
     */
    public function getUpperY()
    {
        return $this->upperY;
    }
}