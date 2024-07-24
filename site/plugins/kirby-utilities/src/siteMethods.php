<?php

use Kirby\Cms\App;
use Kirby\Cms\Url;

return [
  'shortUrl' => function (bool $withLanguageSlug = false): string
  {
    $url = $withLanguageSlug ? $this->url() : App::instance()->url();

    return Url::short($url);
  },
  'navigation' => function (bool $excludeHomePage = false): array
  {
    $pages = $this->pages()->listed();
    $navigation = [];

    foreach ($pages as $page) {
      if (true === $excludeHomePage and $page->isHomePage()) {
        continue;
      }

      $current = false;

      $data = [
        'url' => $page->url(),
        'label' => $page->title(),
        'isHomePage' => $page->isHomePage()
      ];

      if ($page->isActive()) {
        $current = 'page';
      } elseif ($page->isOpen()) {
        $current = 'true';
      }

      $data['current'] = $current;

      $navigation[] = $data;
    }

    return $navigation;
  }
];
