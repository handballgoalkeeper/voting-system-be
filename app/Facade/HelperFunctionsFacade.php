<?php

namespace App\Facade;

class HelperFunctionsFacade
{
    public static function flattenArray(array $array): array
    {
        $result = [];
        foreach ($array as $item) {
            if (is_array($item)) {
                $result = array_merge($result, self::flattenArray($item));
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }
}
