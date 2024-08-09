<?php

use GaetanBt\Kirby\Utilities\Helpers\PanelHelper;

return [
  'environment' => 'production',
  'languages' => true,
  'wearejust.twig.env.filters' => [
    'localizeDateField' => fn($date) => PanelHelper::localizeDateField($date)
  ],
  'date.handler'  => 'intl'
];
