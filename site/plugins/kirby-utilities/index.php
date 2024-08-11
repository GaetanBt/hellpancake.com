<?php

use Kirby\Cms\App;
use GaetanBt\Kirby\Utilities\Seo;

App::plugin('GaetanBt/kirby-utilities', [
  'options' => [
    'seo' => [
      'metaDescriptionFromExcerptLength' => 150,
      'metaTitleSeparator' => '|',
      'generateRobots' => true
    ]
  ],

  'blueprints' => [
    'ku/seo/page' => __DIR__ . '/blueprints/seo-page.yml',
    'ku/seo/site' => __DIR__ . '/blueprints/seo-site.yml',
    'ku/feed/site' => __DIR__ . '/blueprints/feed-site.yml',
    'ku/user/metas' => __DIR__ . '/blueprints/user-metas.yml',
    'ku/fields/toggle' => __DIR__ . '/blueprints/fields/toggle.yml',
  ],

  'hooks' => [
    'page.render:before' => include_once __DIR__ . '/src/hooks/page-render-before.php'
  ],

  'snippets' => [
    'ku/feed/atom' => __DIR__ . '/snippets/atom.php',
    'ku/seo/head' => __DIR__ . '/snippets/seo.php',
    'ku/seo/sitemap' => __DIR__ . '/snippets/sitemap.php'
  ],

  'pageMethods' => include_once __DIR__ . '/src/pageMethods.php',

  'pagesMethods' => include_once __DIR__ . '/src/pagesMethods.php',

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
    ],
    [
      'pattern' => 'sitemap.xml',
      'action' => function () {
        return Seo::sitemap();
      }
    ]
  ]
]);
