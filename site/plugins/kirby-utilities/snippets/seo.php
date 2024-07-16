<?php

/**
 * @global $page
 */

use Kirby\Cms\Html;

$meta_description = $page->getMetaDescription();

echo Html::tag('title', $page->getMetaTitle());

if ($meta_description) {
  echo Html::tag('meta', null, [
    'name' => 'description',
    'content' => $meta_description
  ]);
}
