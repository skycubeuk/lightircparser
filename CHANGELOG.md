# Changelog

## 1.0.4
* Fixed prefix parsing: corrected `strpos` comparisons to use strict `!== false` checks.
* Fixed nick vs servername disambiguation: a prefix without `!` or `@` is now treated as a nick unless it contains `.`, in which case it is treated as a servername.
* Fixed edge case where a message with no parameters would cause an undefined index error.

## 1.0.3
* Added DateTime field.
* Added trim to remove line breaks from raw input.

## 1.0.2
* Added `to_json` function.

## 1.0.1
* Initial release.
