<?php

use src\App;

/**
 * @covers \src\App
 */
class AppTest extends PHPUnit\Framework\TestCase
{
    /** @test */
    public function input_is_missing()
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App([]);
    }

    /** @test */
    public function file_does_not_exist()
    {
        $this->expectException(InvalidArgumentException::class);
        $app = new App(['', 'wrongpath.json']);
    }

    /** @test */
    public function invalid_file()
    {
        file_put_contents(__DIR__.'/invalidfile.txt', 'Random text');
        $this->expectException(InvalidArgumentException::class);
        try {
            $app = new App(['', __DIR__.'/invalidfile.txt']);
        } finally {
            unlink(__DIR__.'/invalidfile.txt');
        }
    }

    /** @test */
    public function empty_file()
    {
        file_put_contents(__DIR__.'/emptyjson.json', '[]');
        $this->expectException(InvalidArgumentException::class);
        try {
            $app = new App(['', __DIR__.'/emptyjson.json']);
        } finally {
            unlink(__DIR__.'/emptyjson.json');
        }
    }
}