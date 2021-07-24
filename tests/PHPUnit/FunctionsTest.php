<?php

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase  {
  
    public function testFunction()
    {
        require 'usersapi.php';

        $obj = new Usersapi();

        $obj->users_table();
    }
}