<?php

namespace App\Models\Utils\Model;

use Illuminate\Database\Eloquent\Model;

trait FieldNullification
{
    /**
     * Throws an \App\Models\Utils\Model\FieldNullification if some field is null
     *
     * @throws ModelException
     */
    public function throwsIfNull (string ...$fields) {
        foreach ($fields as $field) {
            $this->throwsIf(
                condition: $this->isNull($field),
                message: "The specified field '$field' is null on this Model."
            );
        }
    }

    public function isNull (string $field): bool {
        return $this->$field === null;
    }

    /**
     * Throws an \App\Models\Utils\Model\FieldNullification if the condition is TRUE
     *
     * @throws ModelException
     */
    public function throwsIf (bool $condition, string $message) {
        if ($condition) {
            ModelException::make($message, $this)->throw();
        }
    }
}
