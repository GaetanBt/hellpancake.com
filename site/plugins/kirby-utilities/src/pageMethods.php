<?php

use Kirby\Cms\App as Kirby;
use GaetanBt\Kirby\Utilities\Helpers;

return [
  'getMetaDescription' => function (): ?string
  {
    $description = null;
    $meta_description_field = $this->content()->get('ku_meta_description');

    /**
     * If the page has its own meta description field we use it, else we use the `text` field if it has a value.
     */
    if ($meta_description_field->isNotEmpty()) {
      $description = $meta_description_field;
    } else if ($this->text()->isNotEmpty()) {
      $description = $this->text()->excerpt(option('GaetanBt.kirby-utilities.seo.metaDescriptionFromExcerptLength'));
    }

    return $description;
  },
  'getMetaTitle' => function (): string
  {
    $title = '';
    $site_title = Kirby::instance()->site()->content()->get('title');
    $separator = Helpers::getValueFromConfigOrPanel('GaetanBt.kirby-utilities.seo.metaTitleSeparator', 'ku_site_meta_title_separator');
    $meta_title_field = $this->content()->get('ku_meta_title');

    /**
     * If the page has its own meta title field we use it, else if the page has a title set we use it.
     */
    if ($meta_title_field->isNotEmpty() or $this->title()) {
      $page_title = $meta_title_field->isNotEmpty() ? $meta_title_field : $this->title();

      $title = $page_title . ' ' . $separator . ' ' . $site_title;
    }

    return $title;
  },
  'isIndexable' => function (): bool
  {
    $output = true;
    $meta_robots_index_field = $this->content->get('ku_meta_robots_index');

    if ($meta_robots_index_field->isNotEmpty()) {
      $output = $meta_robots_index_field->toBool();
    }

    return $output;
  }
];
