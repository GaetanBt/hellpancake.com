<?php

namespace GaetanBt\Kirby\Utilities;

use Kirby\Cms\App;
use Kirby\Http\Response;

class Seo
{
  public static function robots(): Response
  {
    $exclude_field = App::instance()->site()->content()->get('ku_bots_to_exclude');

    $robots = 'User-agent: *' . PHP_EOL;
    $robots .= 'Disallow:' . PHP_EOL . PHP_EOL;

    if ($exclude_field->isNotEmpty()) {
      $excludes = $exclude_field->toStructure();

      foreach ($excludes as $bot) {
        $robots .= 'User-agent: ' . $bot->name() . PHP_EOL;
        $robots .= 'Disallow: /' . PHP_EOL . PHP_EOL;
      }
    }

    return new Response($robots, 'text/plain', 200);
  }
}
