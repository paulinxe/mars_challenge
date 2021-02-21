<?php

use src\Grid;
use src\Rover;

/**
 * @covers \src\Rover
 */
class RoverTest extends PHPUnit\Framework\TestCase
{
    static $grid;

    public static function setUpBeforeClass(): void
    {
        self::$grid = new Grid('5 5');
    }

    /** @test */
    public function process_instructions()
    {
        $rover = new Rover(self::$grid, '1 2 N', 'LMLMLMLMM');
        $rover->runInstructions();
        $this->assertEquals('1 3 N', $rover->getPosition());

        $rover = new Rover(self::$grid, '3 3 E', 'MMRMMRMRRM');
        $rover->runInstructions();
        $this->assertEquals('5 1 E', $rover->getPosition());
    }

    /** @test */
    public function instructions_overflowing_grid_west()
    {
        $rover = new Rover(self::$grid, '1 2 N', 'LMM');
        $rover->runInstructions();
        $this->assertEquals('0 2 W', $rover->getPosition());
    }

    /** @test */
    public function instructions_overflowing_grid_east()
    {
        $rover = new Rover(self::$grid, '3 2 N', 'RMMM');
        $rover->runInstructions();
        $this->assertEquals(self::$grid->getUpperX().' 2 E', $rover->getPosition());
    }

    /** @test */
    public function instructions_overflowing_grid_north()
    {
        $rover = new Rover(self::$grid, '1 2 N', 'MMMMMM');
        $rover->runInstructions();
        $this->assertEquals('1 '.self::$grid->getUpperX().' N', $rover->getPosition());
    }

    /** @test */
    public function instructions_overflowing_grid_south()
    {
        $rover = new Rover(self::$grid, '1 2 S', 'MMMMM');
        $rover->runInstructions();
        $this->assertEquals('1 0 S', $rover->getPosition());
    }

    /** @test */
    public function rover_can_move_left()
    {
        $rover = new Rover(self::$grid, '1 2 N', 'L');
        $rover->runInstructions();
        $this->assertEquals('1 2 W', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 W', 'L');
        $rover->runInstructions();
        $this->assertEquals('1 2 S', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 S', 'L');
        $rover->runInstructions();
        $this->assertEquals('1 2 E', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 E', 'L');
        $rover->runInstructions();
        $this->assertEquals('1 2 N', $rover->getPosition());
    }

    /** @test */
    public function rover_can_move_right()
    {
        $rover = new Rover(self::$grid, '1 2 N', 'R');
        $rover->runInstructions();
        $this->assertEquals('1 2 E', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 E', 'R');
        $rover->runInstructions();
        $this->assertEquals('1 2 S', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 S', 'R');
        $rover->runInstructions();
        $this->assertEquals('1 2 W', $rover->getPosition());

        $rover = new Rover(self::$grid, '1 2 W', 'R');
        $rover->runInstructions();
        $this->assertEquals('1 2 N', $rover->getPosition());
    }

    /** @test */
    public function bad_initial_position_format()
    {
        $this->expectException(InvalidArgumentException::class);
        $rover = new Rover(self::$grid, 'bad input', '');
    }

    /** @test */
    public function wrong_x_initial_position()
    {
        $this->expectException(InvalidArgumentException::class);
        $rover = new Rover(self::$grid, '6 2 N', '');
    }

    /** @test */
    public function wrong_y_initial_position()
    {
        $this->expectException(InvalidArgumentException::class);
        $rover = new Rover(self::$grid, '2 6 N', '');
    }

    /** @test */
    public function wrong_heading_initial_position()
    {
        $this->expectException(InvalidArgumentException::class);
        $rover = new Rover(self::$grid, '1 1 A', '');
    }
}