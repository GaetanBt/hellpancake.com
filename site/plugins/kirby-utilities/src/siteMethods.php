<?php

use Kirby\Cms\App as Kirby;
use \Kirby\Cms\Url;

return [
  'shortUrl' => function (bool $withLanguageSlug = false): string
  {
    $url = $withLanguageSlug ? $this->url() : Kirby::instance()->url();

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
        'label' => $page->title()
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
