<?php

use Kirby\Cms\Site;

return function (Site $site) {
  $notes_page = $site->children()->findBy('template', 'notes');
  $notes = $notes_page->children()->listedAndTranslated();

  return $notes->sortBy('published_on', 'desc');
};
