<?php

/**
 * @global $page
 */

use Kirby\Cms\Html;

$meta_description = $page->metaDescription();

echo Html::tag('title', $page->metaTitle());

if ($meta_description) {
  echo Html::tag('meta', null, [
    'name' => 'description',
    'content' => $meta_description
  ]);
}

if ($page->isIndexable() === false) {
  echo Html::tag('meta', null, [
    'name' => 'robots',
    'content' => 'noindex, nofollow'
  ]);
}
