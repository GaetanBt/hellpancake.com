<?php

use Kirby\Cms\Site;

return function (Site $site) {
  $blog_page = $site->children()->findBy('template', 'blog');
  $posts = $blog_page->children()->listedAndTranslated();

  return $posts->sortBy('published_on', 'desc');
};
