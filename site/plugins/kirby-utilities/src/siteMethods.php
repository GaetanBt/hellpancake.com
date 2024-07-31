<?php

use Kirby\Cms\App;
use Kirby\Cms\Url;
use Kirby\Cms\Page;

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
  },
  'changelang' => function (Page $page): array
  {
    $available_languages = App::instance()->languages();
    $page_language = App::instance()->language();

    $output = [];

    foreach ($available_languages as $language) {
      $language_code = $language->code();
      $translation_is_available = $page->isTranslatedIn($language_code);

      $output[$language_code] = [
        'code' => $language_code,
        'name' => $language->name(),
        'isActive' => $language === $page_language,
        'translationIsAvailable' => $translation_is_available,
        'url' => $translation_is_available ? $page->url($language_code) : $language->url()
      ];
    }

    return $output;
  }
];
