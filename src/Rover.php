<?php

namespace src;

class Rover
{
    private $x;
    private $y;
    private $heading;
    private $instructions;
    private $grid;

    static $numericHeadings = [
        'N' => 0,
        'E' => 90,
        'S'  => 180,
        'W' => 270
    ];

    /**
     * @param src\Grid $grid The grid where the rover is deployed
     * @param string $initialPosition
     * @param string $instructions
     */
    function __construct(&$grid, $initialPosition, $instructions)
    {
        $initialPosition = explode(' ', $initialPosition);
        if (count($initialPosition) !== 3) {
            throw new \InvalidArgumentException('Initial coordinates are incorrect');
        }

        $this->x = intval($initialPosition[0]);
        $this->y = intval($initialPosition[1]);
        $this->heading = $initialPosition[2];
        $this->instructions = $instructions;
        $this->grid = $grid;

        if (!$this->x || $this->x > $grid->getUpperX()) {
            throw new \InvalidArgumentException('X Coordinate is out of range');
        }

        if (!$this->y || $this->y > $grid->getUpperY()) {
            throw new \InvalidArgumentException('Y Coordinate is out of range');
        }

        if (!in_array($this->heading, ['N', 'E', 'S', 'W'])) {
            throw new \InvalidArgumentException('Invalid heading');
        }
    }

    /**
     * Run the given instructions for this rover
     */
    public function runInstructions()
    {
        for ($i=0; $i<strlen($this->instructions); $i++) {
            switch ($this->instructions[$i]) {
                case 'L':
                    $this->rotateLeft();
                    break;
                case 'R':
                    $this->rotateRight();
                    break;
                case 'M':
                    $this->moveForward();
                    break;
            }
        }
    }

    /**
     * Return the current position and heading
     * @return string
     */
    public function getPosition()
    {
        return "$this->x $this->y $this->heading";
    }

    /**
     * Rotate the heading of the rover to the left
     */
    public function rotateLeft()
    {
        $currentNumericHeading = self::$numericHeadings[$this->heading];
        $currentNumericHeading -= 90;
        if ($currentNumericHeading < 0) {
            $this->heading = 'W';
        } else {
            $this->heading = array_search($currentNumericHeading, self::$numericHeadings);
        }
    }

    /**
     * Rotate the heading of the rover to the right
     */
    public function rotateRight()
    {
        $currentNumericHeading = self::$numericHeadings[$this->heading];
        $currentNumericHeading += 90;
        if ($currentNumericHeading > 270) {
            $this->heading = 'N';
        } else {
            $this->heading = array_search($currentNumericHeading, self::$numericHeadings);
        }
    }

    /**
     * Move the rover forward by one unit
     */
    public function moveForward()
    {
        switch ($this->heading) {
            case 'N':
                if ($this->y < $this->grid->getUpperY()) {
                    $this->y += 1;
                }
                break;
            case 'E':
                if ($this->x < $this->grid->getUpperX()) {
                    $this->x += 1;
                }
                break;
            case 'S':
                if ($this->y > 0) {
                    $this->y -= 1;
                }
                break;
            case 'W':
                if ($this->x > 0) {
                    $this->x -= 1;
                }
                break;
        }
    }
}