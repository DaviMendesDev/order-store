<?php

namespace App\Utils\Endpoints;

use App\Models\Utils\Model\FieldNullification;
use App\Models\Utils\Model\ModelException;
use App\Utils\Aggregator;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use StdClass;
use function collect;

abstract class Endpoint implements EndpointInterface
{
    use FieldNullification;

    /**
     * The endpoint URL to send/receive information
     *
     * @var string
     */
    protected string $url;

    /**
     * The raw (original) data, without format
     *
     * @var mixed
     */
    protected mixed $rawData;

    /**
     * The already formatted data (altered, renamed, etc.)
     *
     * @var mixed
     */
    protected mixed $alteredData;

    /**
     * The representation of field transformation that will be used when sending information
     *
     * @var array
     */
    protected array $renameable;

    /**
     * The dynamic/callable only values, values that are not properties of their objects
     *
     * @var array
     */
    protected array $callable;

    /**
     * The default Headers
     *
     * @var array
     */
    protected array $headers = [
        'Accept' => 'application/json',
        'Content-type' => 'application/json',
    ];

    public function __construct ($rawData) {
        $this->rawData = $rawData;
        $this->alteredData = $this->rawData;
    }

    /**
     * @throws ModelException
     */
    public function send(): Response {
        return $this->prepare()->makeRequest();
    }

    /**
     * @throws ModelException
     */
    public function prepare(): static {
        $this->throwsIfNull('alteredData');

        $this->loadCallables();
        $this->alteredData = Aggregator::rename($this->renameable, $this->alteredData);

        return $this;
    }

    public function makeRequest (): Response {
        return Http::post(
            $this->url,
            collect($this->alteredData)->toArray()
        );
    }

    public function loadCallables () {
        foreach ($this->callable as $methodName => $patternName) {
            $this->alteredData = Aggregator::loadMethodValue(
                $methodName,
                $patternName,
                $this->alteredData,
                $methodName
            );
        }
    }
}
