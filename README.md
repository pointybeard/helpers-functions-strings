# PHP Helpers: String Functions

-   Version: v1.1.0
-   Date: May 23 2019
-   [Release notes](https://github.com/pointybeard/helpers-functions-strings/blob/master/CHANGELOG.md)
-   [GitHub repository](https://github.com/pointybeard/helpers-functions-strings)

A collection of functions for manipulating strings

## Installation

This library is installed via [Composer](http://getcomposer.org/). To install, use `composer require pointybeard/helpers-functions-strings` or add `"pointybeard/helpers-functions-strings": "~1.0"` to your `composer.json` file.

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

### Requirements

There are no particuar requirements for this library other than PHP 7.2 or greater.

To include all the [PHP Helpers](https://github.com/pointybeard/helpers) packages on your project, use `composer require pointybeard/helpers` or add `"pointybeard/helpers": "~1.0"` to your composer file.

## Usage

This library is a collection convenience function for common tasks relating to string manipulation. They are included by the vendor autoloader automatically. The functions have a namespace of `pointybeard\Helpers\Functions\Strings`

The following functions are provided:

-   `utf8_wordwrap() : string`
-   `utf8_wordwrap_array() : array`
-   `type_sensitive_strval() : string`
-   `mb_str_pad(string $input, int $pad_length, string $pad_string = ' ', int $pad_type = STR_PAD_RIGHT, string $encoding = null): string`

Example usage:

```php
<?php

include __DIR__ . '/vendor/autoload.php';

use pointybeard\Helpers\Functions\Strings;

var_dump(Strings\utf8_wordwrap(
    "Some long string that we want to wrap at 20 characeters",
    20, PHP_EOL, true
));
// string(55) "Some long string
// that we want to wrap
// at 20 characeters"

var_dump(Strings\utf8_wordwrap_array(
    "Some long string that we want to wrap at 20 characeters",
    20, PHP_EOL, true
));
// array(3) {
//   [0] => string(16) "Some long string"
//   [1] => string(20) "that we want to wrap"
//   [2] => string(17) "at 20 characeters"
// }

var_dump(Strings\type_sensitive_strval(true));
// string(4) "true"
//
var_dump(Strings\type_sensitive_strval([1,2,3,4]));
// string(5) "array"

var_dump(Strings\type_sensitive_strval(new \stdClass));
// string(6) "object"

var_dump(Strings\mb_str_pad("Apple", 11, "àèò", STR_PAD_LEFT, "UTF-8"));
// string(17) "àèòàèòApple"

var_dump(Strings\mb_str_pad("Banana", 11, "àèò", STR_PAD_RIGHT, "UTF-8"));
// string(16) "Bananaàèòàè"

var_dump(Strings\mb_str_pad("Pear", 11, "àèò", STR_PAD_BOTH, "UTF-8"));
// string(18) "àèòPearàèòà"

```

## Support

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/pointybeard/helpers-functions-strings/issues),
or better yet, fork the library and submit a pull request.

## Contributing

We encourage you to contribute to this project. Please check out the [Contributing documentation](https://github.com/pointybeard/helpers-functions-strings/blob/master/CONTRIBUTING.md) for guidelines about how to get involved.

## License

"PHP Helpers: String Functions" is released under the [MIT License](http://www.opensource.org/licenses/MIT).
