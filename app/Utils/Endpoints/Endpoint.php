<?php

namespace App\Utils\Endpoints;

use App\Models\Utils\Model\FieldNullification;
use App\Models\Utils\Model\ModelException;
use App\Utils\Aggregator;
use Closure;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Illuminate\Http\Client\ConnectionException;
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

    /**
     * @var callable|Closure
     */
    protected ?Closure $customAsyncHandle = null;

    /**
     * @var bool
     */
    protected bool $isAsync = true;

    /**
     * @var PromiseInterface[]
     */
    private static array $promises = [];

    public function __construct ($rawData) {
        $this->rawData = $rawData;
        $this->alteredData = $this->rawData;
    }

    /**
     * @throws \Throwable
     */
    public static function waitAllPromisesFinish() {
        return Utils::unwrap(self::$promises);
    }

    /**
     * @param callable|Closure $callbackHandle
     * @return void
     */
    public function setCustomAsyncHandle (callable|Closure $callbackHandle) {
        $this->customAsyncHandle = $callbackHandle;
    }

    /**
     * @return callable|Closure
     */
    public function getCustomAsyncHandle(): Closure|callable|null {
        return $this->customAsyncHandle;
    }

    public function runCustomAsyncHandle(Response|ConnectionException $response) {
        return ($this->getCustomAsyncHandle())($response);
    }

    /**
     * @return bool
     */
    public function hasCustomAsyncHandle(): bool {
        return (bool) $this->getCustomAsyncHandle();
    }

    /**
     * @throws ModelException
     */
    public function send(): Response|PromiseInterface {
        self::$promises[] = $httpResponse = $this->prepare()->makeRequest();
        return $httpResponse;
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

    public function makeRequest (): PromiseInterface|Response
    {
        return $this->isAsync
            ? Http::async()->withHeaders($this->headers)->withOptions(['debug' => true])->post($this->url, collect($this->alteredData)->toArray())->then(function ($response) {
                return $this->hasCustomAsyncHandle() ? $this->runCustomAsyncHandle($response) : $this->asyncHandle($response);
            })
            : Http::withHeaders($this->headers)->post($this->url, collect($this->alteredData)->toArray());
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

    protected function asyncHandle(Response|ConnectionException $response) {
        return null;
    }

    /**
     * @return mixed
     */
    public function getAlteredData(): mixed
    {
        return $this->alteredData;
    }

    /**
     * @return array
     */
    public function getRenameable(): array
    {
        return $this->renameable;
    }

    /**
     * @return mixed
     */
    public function getRawData(): mixed
    {
        return $this->rawData;
    }
}
