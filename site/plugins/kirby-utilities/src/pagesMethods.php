<?php

use Kirby\Cms\Pages;

return [
  /**
   * Filter listed and translated pages based on the Kirby `listed()` Page method and the Kirby Utilities `translated()` Pages method.
   */
  'listedAndTranslated' => function (): Pages
  {
    return $this->listed()->translated();
  },

  /**
   * Filter pages based on the Kirby Utilities `isTranslated()` Page method.
   */
  'translated' => function(): Pages
  {
    return $this->filter(
      fn($child) => $child->isTranslated()
    );
  }
];
