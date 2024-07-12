<?php

use \Kirby\Cms\App as Kirby;

Kirby::plugin('GaetanBt/kirby-utilities', [
  'options' => [
    'metaDescriptionLength' => 120,
    'metaTitleSeparator' => '|',
    'metaTitleField' => 'meta_title',
    'metaDescriptionField' => 'meta_description'
  ],

  'pageMethods' => include_once __DIR__ . '/src/pageMethods.php',

  'siteMethods' => include_once __DIR__ . '/src/siteMethods.php',

  'tags' => include_once __DIR__ . '/src/tags.php'
]);
