<?php

declare(strict_types=1);

namespace pointybeard\Helpers\Functions\Strings;

/*
 * Credit to ju1ius for original version of this method
 * https://www.php.net/manual/en/function.wordwrap.php#107570
 * @return string word wrapped string
 */
if (!function_exists(__NAMESPACE__.'utf8_wordwrap')) {
    function utf8_wordwrap(string $input, int $width = 80, string $break = PHP_EOL, bool $cut = false): string
    {
        // Safety first!
        $width_quoted = preg_quote((string) $width);
        $break_quoted = preg_quote($break);

        // Default pattern and replace. Will not cut words in half.
        $pattern = "@(?=\s)(.{1,{$width_quoted}})(?:\s|\$)@uS";
        $replace = "\$1{$break_quoted}";

        // This will cut in the middle of a word
        if (false !== $cut) {
            $pattern = "@(.{1,{$width_quoted}})(?:\s|\$)|(.{{$width_quoted}})@uS";
            $replace = "\$1\$2{$break_quoted}";
        }

        return trim(preg_replace($pattern, $replace, $input), $break);
    }
}

/*
 * Uses utf8_wordwrap() and then splits by $break to create an array of strings
 * no longer than $width.
 * @see utf8_wordwrap()
 * @return array an array of strings
 */
if (!function_exists(__NAMESPACE__.'utf8_wordwrap_array')) {
    function utf8_wordwrap_array(string $input, int $width = 80, string $break = PHP_EOL, bool $cut = false): array
    {
        $modified = utf8_wordwrap($input, $width, $break, $cut);

        return preg_split('@'.preg_quote($break).'@', $modified);
    }
}

/*
 * This function will convert $value input to a string but first inspect
 * to see what type of value has been passed in. Allows easy conversion of
 * boolean to true/false literal string value. Also safely converts array,
 * object, resource, and 'unknown type' to string representation.
 * @return string
 */
if (!function_exists(__NAMESPACE__.'type_sensitive_strval')) {
    function type_sensitive_strval($value): string
    {
        $result = null;
        $type = gettype($value);

        switch ($type) {
            case 'boolean':
                $result = true === $value ? 'true' : 'false';
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
                $result = (string) $value;
                break;
        }

        return $result;
    }
}

/*
 * A multibyte safe version of str_pad()
 * Credit to Wes (original author) and Dereckson (PHP7 compatibility update)
 * https://stackoverflow.com/a/27194169
 */
if (!function_exists(__NAMESPACE__.'mb_str_pad')) {
    function mb_str_pad(string $input, int $pad_length, string $pad_string = ' ', int $pad_type = STR_PAD_RIGHT, string $encoding = null): string
    {
        $encoding = (
            null === $encoding
                ? mb_internal_encoding()
                : $encoding
        );

        $padBefore = (STR_PAD_BOTH === $pad_type || STR_PAD_LEFT === $pad_type);
        $padAfter = (STR_PAD_BOTH === $pad_type || STR_PAD_RIGHT === $pad_type);

        $pad_length -= mb_strlen($input, $encoding);

        $targetLength = (
            true == $padBefore && true == $padAfter
                ? $pad_length / 2
                : $pad_length
        );

        $repeatTimes = max(0, ceil($targetLength / mb_strlen($pad_string, $encoding)));

        // safe if used with valid unicode sequences (any charset)
        $repeatedString = str_repeat($pad_string, (int)$repeatTimes);

        $before = (
            true == $padBefore
                ? mb_substr($repeatedString, 0, (int) floor($targetLength), $encoding)
                : ''
        );

        $after = (
            true == $padAfter
                ? mb_substr($repeatedString, 0, (int) ceil($targetLength), $encoding)
                : ''
        );

        return "{$before}{$input}{$after}";
    }
}
