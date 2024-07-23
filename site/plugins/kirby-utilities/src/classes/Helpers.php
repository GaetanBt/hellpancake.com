<?php

namespace GaetanBt\Kirby\Utilities;

use GaetanBt\Kirby\Utilities\Enum\FieldOrigin;

final class Helpers
{
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
}
