<?php

use Kirby\Exception\NotFoundException;
use GaetanBt\Kirby\Utilities\Seo;

return [
  'metaDescription' => fn() => Seo::description($this),
  'metaTitle'       => fn() => Seo::title($this),
  'isIndexable'     => fn() => Seo::isIndexable($this),

  /**
   * Check if there is some content on the destination page `text` field
   *
   * @throws Kirby\Exception\NotFoundException if the `ku_page_is_translated` field name is not found in the ContentTranslation `content` array.
   */
  'isTranslatedIn' => function (string $languageCode): bool
  {
    return $this->isTranslated($languageCode);
  },

  /**
   * Check if the current page is translated
   *
   * @throws Kirby\Exception\NotFoundException if the `ku_page_is_translated` field is empty.
   */
  'isTranslated' => function (?string $languageCode = null): bool
  {
    if (null !== $languageCode and false === $this->translation($languageCode)->exists()) {
      return false;
    }

    $field_name = 'ku_page_is_translated';
    $field = $this->content($languageCode)->get($field_name);

    if ($field->isEmpty()) {
      throw new NotFoundException($field_name . ' field was not found.');
    }

    return $field->toBool();
  }
];
