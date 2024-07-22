<?php

use Kirby\Cms\App as Kirby;
use GaetanBt\Kirby\Utilities\Seo;

Kirby::plugin('GaetanBt/kirby-utilities', [
  'options' => [
    'seo' => [
      'metaDescriptionFromExcerptLength' => 120,
      'metaTitleSeparator' => '|',
      'generateRobots' => true
    ]
  ],

  'blueprints' => [
    'ku/seo/page' => __DIR__ . '/blueprints/seo-page.yml',
    'ku/seo/site' => __DIR__ . '/blueprints/seo-site.yml'
  ],

  'snippets' => [
    'ku/seo/head' => __DIR__ . '/snippets/seo.php'
  ],

  'pageMethods' => include_once __DIR__ . '/src/pageMethods.php',

  'siteMethods' => include_once __DIR__ . '/src/siteMethods.php',

  'tags' => include_once __DIR__ . '/src/tags.php',

  'translations' => [
    'en' => include_once __DIR__ . '/src/translations/en.php',
    'fr' => include_once __DIR__ . '/src/translations/fr.php',
  ],

  'routes' => [
    [
      'pattern' => 'robots.txt',
      'action' => function () {
        if (option('GaetanBt.kirby-utilities.seo.generateRobots') === true) {
          return Seo::robots();
        }

        $this->next();
      }
    ]
  ]
]);
