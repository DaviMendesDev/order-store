<?php

namespace App\Utils\Endpoints;

interface EndpointInterface
{
    public function send();
    public function prepare();
}
