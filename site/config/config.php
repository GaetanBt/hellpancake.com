<?php

use GaetanBt\Kirby\Utilities\Helpers;

return [
  'environment' => 'production',
  'languages' => true,
  'wearejust.twig.env.filters' => [
    'localizeDateField' => fn($date) => Helpers::localizeDateField($date)
  ],
  'date.handler'  => 'intl'
];
