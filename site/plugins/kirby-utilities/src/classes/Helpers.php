<?php

namespace GaetanBt\Kirby\Utilities;

use IntlDateFormatter;
use Kirby\Cms\App;
use Kirby\Content\Field;
use GaetanBt\Kirby\Utilities\Enum\FieldOrigin;

final class Helpers
{
  /**
   * Get a value from the configuration file or from the panel if it exists.
   */
  public static function getValueFromConfigOrPanel (string $configKey, string $fieldName, FieldOrigin $origin = FieldOrigin::Site): mixed
  {
    $field = $origin->field($fieldName);

    if ($field->isNotEmpty()) {
      return $field;
    }

    if ($configValue = option($configKey)) {
      return $configValue;
    }

    return null;
  }

  /**
   * Provide a localized date from a Kirby date field.
   * This requires the use of the `intl` date handler instead of PHP's `date` function
   *
   * @see https://getkirby.com/docs/guide/languages#language-specific-date-handlers
   */
  public static function localizeDateField(Field $dateField, ?string $locale = null): string
  {
    if (null === $locale) {
      $locale = App::instance()->language()->locale(LC_ALL);
    }

    $formatter = new IntlDateFormatter(
      $locale,
      IntlDateFormatter::LONG,
      IntlDateFormatter::NONE
    );

    return $formatter->format($dateField->toDate());
  }
}
