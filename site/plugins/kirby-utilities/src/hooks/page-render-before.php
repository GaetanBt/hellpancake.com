<?php

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Cms\Response;

return function (string $contentType, array $data, Page $page) {
  if (false === App::instance()->multilang() or $page->isTranslated()) {
    return $data;
  }

  if (true === App::instance()->option('debug')) {
    var_dump('[page.render:before] → Page is not translated.');
    return $data;
  }

  Response::go(App::instance()->language()->url());
};
