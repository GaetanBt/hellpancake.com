<?php

use GaetanBt\Kirby\Utilities\Helpers\UserHelper;
use Kirby\Cms\Page;

function containsBlockType(Page $page, string $blockType): bool
{
  $field = $page->text();

  if ($field->isEmpty()) {
    return false;
  }

  $output = false;

  foreach ($field->toBlocks() as $block) {
    if ($block->type() === $blockType) {
      $output = true;
    }
  }

  return $output;
}

return function(Page $page): array
{
  $author = $page->author()->toUser();

  return [
    'author' => [
      'name' => UserHelper::name($author)
    ],
    'containsCodeBlock' => containsBlockType($page, 'code')
  ];
};
