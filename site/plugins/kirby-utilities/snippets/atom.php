<?php

/**
 * @global $pages
 * @global $ignore
 * @global $languageCode
 */

use Kirby\Cms\App;
use Kirby\Cms\Url;
use Kirby\Toolkit\Str;
use GaetanBt\Kirby\Utilities\Atom;

$kirby = App::instance();
$site = $kirby->site()->content($languageCode);

$atom = new Atom($languageCode, [
  'title' => $site->get('ku_site_feed_atom_title'),
  'subtitle' => $site->get('ku_site_feed_atom_subtitle'),
  'updated' => date('c'), // todo
  'link' => $kirby->url(),
  'feedUrl' => Url::current(),
]);

foreach ($pages as $post) {
  if (in_array($post->uri(), $ignore) or false === $post->isTranslatedIn($languageCode)) continue;

  $published = $post->content($languageCode)->published_on();
  $updated = $post->content($languageCode)->updated_on();

  if ($updated->isEmpty()) {
    $updated = $published;
  }

  $atom->entry([
    'title'     => $post->content($languageCode)->title(),
    'published' => date('c', $published->toDate()),
    'updated'   => date('c', $updated->toDate()),
    'summary'   => Str::unhtml($post->content($languageCode)->excerpt()),
    'link'      => $post->url($languageCode),
    'author' => [
      'name' => 'todo name',
      'uri' => 'todo uri'
    ], // todo
  ]);
}

$atom->render();
