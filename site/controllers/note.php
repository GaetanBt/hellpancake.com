<?php

use GaetanBt\Kirby\Utilities\Helpers\UserHelper;
use Kirby\Cms\Page;

return function(Page $page): array
{
  $author = $page->author()->toUser();

  return [
    'author' => [
      'name' => UserHelper::name($author)
    ]
  ];
};
