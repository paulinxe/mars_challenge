<?php

namespace src;

class App
{
    protected $grid;
    protected $rovers = [];

    /**
     * @param array $args Command line arguments
     */
    function __construct($args)
    {
        if (!isset($args[1])) {
            throw new \InvalidArgumentException('Input file is missing');
        }

        if (!file_exists($args[1])) {
            throw new \InvalidArgumentException('Input file does not exist');
        }

        $input = json_decode(file_get_contents($args[1]));
        if (json_last_error()) {
            throw new \InvalidArgumentException('Input file is not a valid JSON');
        }

        if (!$input) {
            throw new \InvalidArgumentException('Input file is empty');
        }

        $grid = new Grid($input[0]);

        $i = 1;
        $roversCounter = 1;
        while ($i<count($input)) {
            try {
                $rover = new Rover($grid, $input[$i], $input[$i+1]);
                $this->rovers[$roversCounter] = $rover;
            } catch (\Exception $e) {
                // As we may have many rovers, we want the rest of them to be
                // able to be created and interact in Mars.
                // Therefore, catch the exception
                print("Error in Rover $roversCounter: {$e->getMessage()}\n");
            }

            $i += 2;
            $roversCounter += 1;
        }
    }

    public function run()
    {
        foreach ($this->rovers as $i => $rover) {
            $rover->runInstructions();
            echo "Rover $i: {$rover->getPosition()}\n";
        }
    }
}