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
use GaetanBt\Kirby\Utilities\Helpers\StringHelper;
use GaetanBt\Kirby\Utilities\Helpers\UserHelper;
use GaetanBt\Kirby\Utilities\Enum\UserInfoDestination;

$kirby = App::instance();
$site = $kirby->site()->content($languageCode);

$atom = new Atom($languageCode, [
  'title' => $site->get('ku_site_feed_atom_title'),
  'subtitle' => $site->get('ku_site_feed_atom_subtitle'),
  'updated' => date('c'), // todo
  'link' => StringHelper::withTrailingSlash($kirby->url()),
  'feedUrl' => Url::current(),
]);

foreach ($pages as $post) {
  if (in_array($post->uri(), $ignore) or false === $post->isTranslatedIn($languageCode)) continue;

  $p = $post->content($languageCode);

  $author = $p->author()->toUser();
  $published = $p->published_on();
  $updated = $p->updated_on();

  if ($updated->isEmpty()) {
    $updated = $published;
  }

  $atom->entry([
    'title'     => $p->title(),
    'published' => date('c', $published->toDate()),
    'updated'   => date('c', $updated->toDate()),
    'summary'   => Str::unhtml($p->excerpt()),
    'link'      => StringHelper::withTrailingSlash($post->url($languageCode)),
    'author' => [
      'name' => UserHelper::name($author),
      'uri' => StringHelper::withTrailingSlash(UserHelper::website($author)),
      'email' => UserHelper::email($author, UserInfoDestination::SitemapXML)
    ]
  ]);
}

$atom->render();
