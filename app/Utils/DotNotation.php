<?php

namespace App\Utils;

class DotNotation
{
    public function __construct (private string $text) { }

    public function appliesTo (string $pattern): bool {
        $patternSplit = explode('.', $pattern);
        $textSplit = explode('.', $this->text);

        if (count($textSplit) != count($patternSplit))
            return false;

        foreach ($patternSplit as $i => $str) {
            if ($str == '*') {
                continue;
            }

            if ($str != $textSplit[$i])
                return false;
        }

        return true;
    }

    public function transformTo (string $pattern): string {
        $patternSplit = explode('.', $pattern);
        $textSplit = explode('.', $this->text);
        $result = [];

        foreach ($patternSplit as $i => $str) {
            if ($str == '*') {
                $result[] = $textSplit[$i];
                continue;
            }

            $result[] = $str;
        }

        return implode('.', $result);
    }
}
