<?php

if (!function_exists('toCamelCase')) {
    /**
     * Convert a string to camelCase.
     *
     * @param string $string
     * @param bool $capitalizeFirst
     * @return string
     */
    function toCamelCase(string $string, bool $capitalizeFirst = false): string
    {
        $string = str_replace(['-', '_'], ' ', strtolower($string));
        $string = str_replace(' ', '', ucwords($string));

        return $capitalizeFirst ? $string : lcfirst($string);
    }
}
