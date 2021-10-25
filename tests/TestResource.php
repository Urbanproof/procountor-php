<?php

namespace Procountor\Tests;

use Procountor\Procountor\Interfaces\AbstractResourceInterface;

class TestResource implements AbstractResourceInterface
{

    public function getTestAttribute(): string
    {
        return 'This is a test.';
    }

}
