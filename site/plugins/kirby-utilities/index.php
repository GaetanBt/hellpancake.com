<?php

use \Kirby\Cms\App as Kirby;

Kirby::plugin('GaetanBt/kirby-utilities', [
  'options' => [
    'metaDescriptionFromExcerptLength' => 120,
    'metaTitleSeparator' => '|',
  ],

  'blueprints' => [
    'ku/seo/page' => __DIR__ . '/blueprints/seo-page.yml'
  ],

  'snippets' => [
    'ku/seo/head' => __DIR__ . '/snippets/seo.php'
  ],

  'pageMethods' => include_once __DIR__ . '/src/pageMethods.php',

  'siteMethods' => include_once __DIR__ . '/src/siteMethods.php',

  'tags' => include_once __DIR__ . '/src/tags.php'
]);
