<?php

namespace App\Traits\Enum;

trait Options
{
    public static function options(): array
    {
        $cases = static::cases();

        foreach($cases as $case){
            $result[$case->value] = $case->label();
        }

        return $result;
    }

    public static function optionsWithoutLabel(): array
    {
        $cases = static::cases();

        foreach($cases as $case){
            $result[] = $case->value;
        }

        return $result;
    }
}
