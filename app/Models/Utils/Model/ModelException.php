<?php

namespace App\Models\Utils\Model;

use Illuminate\Database\Eloquent\Model;

class ModelException extends \Exception
{
    public function __construct (string $message, private Model $model) {
        parent::__construct($message);
    }

    /**
     * Returns the Exception's Model
     *
     * @return Model
     */
    public function getModel (): Model {
        return $this->model;
    }

    /**
     * @throws ModelException
     *
     * Throws this Exception Object
     */
    public function throw () {
        throw $this;
    }

    public static function make (string $message, Model $model): ModelException {
        return new self($message, $model);
    }
}
