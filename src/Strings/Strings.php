<?php

namespace pointybeard\Helpers\Functions\Strings;

/**
 * Credit to ju1ius for original version of this method
 * https://www.php.net/manual/en/function.wordwrap.php#107570
 * @return string word wrapped string
 */
if (!function_exists(__NAMESPACE__ . "utf8_wordwrap")) {
    function utf8_wordwrap($string, $width=80, $break=PHP_EOL, $cut=false)
    {

        // Safety first!
        $width_quoted = preg_quote((string)$width);
        $break_quoted = preg_quote($break);

        // Default pattern and replace. Will not cut words in half.
        $pattern = "@(?=\s)(.{1,{$width_quoted}})(?:\s|\$)@uS";
        $replace = "\$1{$break_quoted}";

        // This will cut in the middle of a word
        if ($cut !== false) {
            $pattern = "@(.{1,{$width_quoted}})(?:\s|\$)|(.{{$width_quoted}})@uS";
            $replace = "\$1\$2{$break_quoted}";
        }

        return trim(preg_replace($pattern, $replace, $string), $break);
    }
}

/**
 * Uses utf8_wordwrap() and then splits by $break to create an array of strings
 * no longer than $width.
 * @see utf8_wordwrap()
 * @return array an array of strings
 */
if (!function_exists(__NAMESPACE__ . "utf8_wordwrap_array")) {
    function utf8_wordwrap_array($string, $width=80, $break=PHP_EOL, $cut=false)
    {
        $modified = utf8_wordwrap($string, $width, $break, $cut);
        return preg_split('@'.preg_quote($break).'@', $modified);
    }
}

/**
 * This function will convert $value input to a string but first inspect
 * to see what type of value has been passed in. Allows easy conversion of
 * boolean to true/false literal string value. Also safely converts array,
 * object, resource, and 'unknown type' to string representation.
 * @return string
 */
if (!function_exists(__NAMESPACE__ . "type_sensitive_strval")) {
    function type_sensitive_strval($value)
    {
        $result = null;
        $type = gettype($value);

        switch($type) {
            case 'boolean':
                $result = $value === true ? 'true' : 'false';
                break;

            case 'null':
                $result = 'NULL';
                break;

            case 'object':
            case 'array':
            case 'resource':
            case 'unknown type':
                $result = $type;
                break;

            default:
                $result = (string)$value;
                break;
        }

        return $result;
    }
}
