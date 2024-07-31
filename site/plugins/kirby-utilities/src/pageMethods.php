<?php

use Kirby\Cms\App;
use Kirby\Content\Field;
use Kirby\Exception\NotFoundException;
use GaetanBt\Kirby\Utilities\Helpers;

return [
  'getMetaDescription' => function (): ?string
  {
    $description = null;
    $meta_description_field = $this->content()->get('ku_meta_description');
    $default_description_length = Helpers::getValueFromConfigOrPanel('GaetanBt.kirby-utilities.seo.metaDescriptionFromExcerptLength', 'ku_site_meta_description_from_excerpt_length');

    if ($default_description_length instanceof Field) {
      $default_description_length = $default_description_length->toInt();
    }

    /**
     * If the page has its own meta description field we use it, else we use the `text` field if it has a value.
     */
    if ($meta_description_field->isNotEmpty()) {
      $description = $meta_description_field;
    } else if ($this->text()->isNotEmpty()) {
      $description = $this->text()->excerpt($default_description_length);
    }

    return $description;
  },
  'getMetaTitle' => function (): string
  {
    $title = '';
    $site_title = App::instance()->site()->content()->get('title');
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
  },
  /**
   * Check if there is some content on the destination page `text` field
   */
  'isTranslatedIn' => function (string $languageCode): bool
  {
    if (false === $this->translation($languageCode)->exists()) {
      return false;
    }

    $field_name = 'ku_page_is_translated';
    $content_translation = $this->translation($languageCode)->content();

    if (false === array_key_exists($field_name, $content_translation)) {
      throw new NotFoundException($field_name . ' field was not found.');
    }

    return filter_var($content_translation[$field_name], FILTER_VALIDATE_BOOLEAN);
  },
  'isTranslated' => function (): bool
  {
    $field_name = 'ku_page_is_translated';
    $field = $this->content()->get($field_name);

    if ($field->isEmpty()) {
      throw new NotFoundException($field_name . ' field was not found.');
    }

    return $field->toBool();
  }
];
