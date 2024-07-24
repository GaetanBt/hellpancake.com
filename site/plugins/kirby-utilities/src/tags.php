<?php

use Kirby\Toolkit\Html;

return [
  'abbr' => [
    'attr' => [
      'title'
    ],
    'html' => function ($tag): string {
      $visually_hidden_content = Html::tag(
        'span',
        ' (' . $tag->title . ')',
        [
          'class' => 'visually-hidden'
        ]
      );

      return Html::tag(
        'abbr',
        [
          $tag->value,
          $visually_hidden_content
        ],
        [
          'title' => $tag->title
        ]
      );
    }
  ]
];
