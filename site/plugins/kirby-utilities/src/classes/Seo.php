<?php

namespace GaetanBt\Kirby\Utilities;

use GaetanBt\Kirby\Utilities\Helpers\PanelHelper;
use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Content\Field;
use Kirby\Http\Response;

class Seo
{
  public static function title(Page $page): string
  {
    $title = '';
    $site_title = App::instance()->site()->content()->get('title');
    $separator = PanelHelper::getValueFromConfigOrPanel('GaetanBt.kirby-utilities.seo.metaTitleSeparator', 'ku_site_meta_title_separator');
    $field = $page->content()->get('ku_meta_title');

    /**
     * If the page has its own meta title field we use it, else if the page has a title set we use it.
     */
    if ($field->isNotEmpty() or $page->title()) {
      $page_title = $field->isNotEmpty() ? $field : $page->title();

      $title = $page_title . ' ' . $separator . ' ' . $site_title;
    }

    return $title;
  }

  public static function description(Page $page): ?string
  {
    $description = null;
    $field = $page->content()->get('ku_meta_description');
    $default_description_length = PanelHelper::getValueFromConfigOrPanel('GaetanBt.kirby-utilities.seo.metaDescriptionFromExcerptLength', 'ku_site_meta_description_from_excerpt_length');

    if ($default_description_length instanceof Field) {
      $default_description_length = $default_description_length->toInt();
    }

    /**
     * If the page has its own meta description field we use it, else we use the `text` field if it has a value.
     */
    if ($field->isNotEmpty()) {
      $description = $field;
    } else if ($page->text()->isNotEmpty()) {
      $description = $page->text()->excerpt($default_description_length);
    }

    return $description;
  }

  public static function isIndexable(Page $page): bool
  {
    $output = true;
    $field = $page->content->get('ku_meta_robots_index');

    if ($field->isNotEmpty()) {
      $output = $field->toBool();
    }

    return $output;
  }

  public static function robots(): Response
  {
    $exclude_field = App::instance()->site()->content()->get('ku_bots_to_exclude');

    $robots = 'User-agent: *' . PHP_EOL;
    $robots .= 'Disallow:' . PHP_EOL . PHP_EOL;

    $robots .= 'Sitemap: ' . App::instance()->url() . '/sitemap.xml' . PHP_EOL . PHP_EOL;

    if ($exclude_field->isNotEmpty()) {
      $excludes = $exclude_field->toStructure();

      foreach ($excludes as $bot) {
        $robots .= 'User-agent: ' . $bot->name() . PHP_EOL;
        $robots .= 'Disallow: /' . PHP_EOL . PHP_EOL;
      }
    }

    return new Response($robots, 'text/plain', 200);
  }

  public static function sitemap(): Response
  {
    $pages = App::instance()->site()->pages()->index()->listed();

    $ignore = App::instance()->option('GaetanBt.kirby-utilities.seo.sitemap.ignore', ['error']);
    $content = snippet('ku/seo/sitemap', compact('pages', 'ignore'), true);

    return new Response($content, 'application/xml', 200);
  }

  public static function feed(string $languageCode, string $intendedTemplate): Response
  {
    $pages = App::instance()->site()->children()->findBy('intendedTemplate', $intendedTemplate)->index();

    $ignore = App::instance()->option('GaetanBt.kirby-utilities.seo.feed.ignore', []);
    $content = snippet('ku/feed/atom', compact('pages', 'ignore', 'languageCode'), true);

    return new Response($content, 'application/xml', 200);
  }
}
