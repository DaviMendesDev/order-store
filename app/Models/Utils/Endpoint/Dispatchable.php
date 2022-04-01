<?php

namespace App\Models\Utils\Endpoint;

use App\Models\Utils\Model\FieldNullification;
use App\Utils\Endpoints\Endpoint;

trait Dispatchable
{
    use FieldNullification;

    public function dispatch () {
        $this->throwsIfNull('dispatchEndpoints');
        foreach ($this->dispatchEndpoints as $endpointClassName) {
            $e = new $endpointClassName($this);
            $this->throwsIf(! ($e instanceof Endpoint), 'the $e variable is not an appropriated instance of Endpoint');

            if (! ($e instanceof Endpoint)) return;
            $e->send();
        };
    }
}
