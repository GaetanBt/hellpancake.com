<?php

/**
 * @global $pages
 * @global $ignore
 */

$kirby = Kirby\Cms\App::instance();

function urlBloc($loc, $lastmod, $priority): string
{
  $str = '<url><loc>%s</loc><lastmod>%s</lastmod><priority>%s</priority></url>';

  return sprintf($str, html($loc), $lastmod, $priority);
}

echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

foreach ($pages as $p) {
  if (in_array($p->uri(), $ignore)) continue;

  $lastmod = $p->modified('c', 'date');
  $priority = ($p->isHomePage()) ? 1 : number_format(0.5 / $p->depth(), 1);

  if (true === $kirby->multilang()) {
    foreach ($kirby->languages() as $language) {
      if (false === $p->isTranslatedIn($language->code())) continue;

      echo urlBloc(
        $p->url($language->code()),
        $lastmod,
        $priority
      );
    }
  } else {
    echo urlBloc($p->url(), $lastmod, $priority);
  }
};

echo '</urlset>';
