<?php

namespace Procountor\Procountor\Response;

use stdClass;

abstract class AbstractResponse
{
    protected $data;

    public function __construct(stdClass $data)
    {
        $this->data = $data;
    }
}
