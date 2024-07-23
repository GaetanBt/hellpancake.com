<?php

namespace GaetanBt\Kirby\Utilities\Enum;

use Kirby\Cms\App;
use Kirby\Content\Field;

enum FieldOrigin
{
  case Page;
  case Site;

  public function field (string $fieldName): Field|array
  {
    return match($this) {
      FieldOrigin::Page => App::instance()->page()->content()->get($fieldName),
      FieldOrigin::Site => App::instance()->site()->content()->get($fieldName),
    };
  }
}
