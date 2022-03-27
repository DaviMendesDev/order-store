<?php

namespace App\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

abstract class Aggregator
{
    public static function agregateBy (string $key, Array $arr = null) {
        return collect($arr)->mapToGroups(function ($item, $key) {
            return [ $item['article_code'] => $item ];
        });
    }

    public static function each (array $items, callable $callback) {
        return collect($items)->each($callback);
    }

    /**
     * Renames the key of a given array $data based on the array $tuplesOfNames
     *
     * the array $tuplesOfNames must be in the format where the old name must be the key and the new name
     * must be the value, like below:
     *
     * $tuplesOfNames = [
     *      'old_key' => 'new_key',
     *      ...
     * ]
     *
     * @param array $tuplesOfKeys the tuple of new names, the old names must be the keys while the new names must be the values
     * @param array $data the array to apply the renomeation
     * @return array
     */
    public static function rename (array $tuplesOfKeys, mixed $data): array {
        foreach ($tuplesOfKeys as $oldKey => $newKey) {
            self::renameKey($oldKey, $newKey, $data);
        }

        return $data;
    }

    private static function renameKey (string $oldPattern, string $newPattern, mixed &$data) {
        $data = Arr::dot(collect($data)->toArray());

        foreach ($data as $rawDotNotationKey => $value) {
            $dotNotationObj = new DotNotation($rawDotNotationKey);
            if ($dotNotationObj->appliesTo($oldPattern)) {
                self::addAndForget($rawDotNotationKey, $value, $data, $dotNotationObj->transformTo($newPattern));
            }
        }

        $data = collect($data)->undot()->toArray();
    }

    public static function addAndForget (string $target, mixed $copiedValue, array &$data, string $newKey) {
        $data[$newKey] = $copiedValue;
        $data = collect($data)->forget($target)->toArray();
    }

    public static function loadMethodValue (string $methodName, string $pattern, mixed $data, string $key) {
        $splitPattern = explode('.', $pattern);
        $copy = $data;

        self::loadMethodValueRecursive(
            $copy,
            count($splitPattern) - 1,
            $splitPattern,
            $methodName,
            $key
        );

        return $copy;
    }

    private static function loadMethodValueRecursive (
        mixed  &$data,
        int    $maxPos,
        array  $splitPattern,
        string $methodName,
        string $key,
        int    $currentPos = 0
    ) {
        if ($currentPos == $maxPos) {
            $data->$key = $data->$methodName();
            return;
        }

        $nextKey = $splitPattern[$currentPos + 1];

        if ($nextKey == '*') {
            foreach ($data as $d) {
                self::loadMethodValueRecursive($d, $maxPos, $splitPattern, $methodName, $key, $currentPos + 1);
            }
        } else {
            self::loadMethodValueRecursive(
                $data[$nextKey],
                $maxPos,
                $splitPattern,
                $methodName,
                $key,
                $currentPos + 1
            );
        }
    }

    public static function isArray(mixed $data) {
        return is_array($data);
    }

    /**
     * return the value from the key on "dot" notation, if working with asterisks "*" values, returns an array
     *
     * @param string $key the key on "dot" notation to search for
     * @param array $data the given array to search into it
     * @return array|mixed
     */
    public static function value (string $key, array $data): mixed {
        return data_get($data, $key);
    }

    public static function set (string $key, mixed $value, array $data) {
        return data_set($data, $key, $value);
    }
}
