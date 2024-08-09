<?php

namespace GaetanBt\Kirby\Utilities\Helpers;

use Kirby\Toolkit\Str;

class StringHelper
{
  public static function withTrailingSlash(string $url): string
  {
    if (false === Str::endsWith($url, '/')) {
      $url .= '/';
    }

    return $url;
  }
}
