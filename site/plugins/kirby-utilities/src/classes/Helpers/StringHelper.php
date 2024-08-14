<?php

namespace GaetanBt\Kirby\Utilities\Helpers;

use Kirby\Toolkit\Str;

class StringHelper
{
  public static function withTrailingSlash(string $str): string
  {
    if (false === Str::endsWith($str, '/')) {
      $str .= '/';
    }

    return $str;
  }
}
