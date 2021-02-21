<?php

use src\Grid;

/**
 * @covers \src\Grid
 */
class GridTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function parses_coordinates()
    {
        $grid = new Grid('2 2');
        $this->assertEquals(2, $grid->getUpperX());
        $this->assertEquals(2, $grid->getUpperY());
    }
    
    /** @test */
    public function empty_dimensions()
    {
        $this->expectException(InvalidArgumentException::class);
        $grid = new Grid('');
    }

    /** @test */
    public function invalid_dimensions()
    {
        $this->expectException(InvalidArgumentException::class);
        $grid = new Grid('-1 0');
    }
}