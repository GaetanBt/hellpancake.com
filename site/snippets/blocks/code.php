<?php

/**
 * @var \Kirby\Cms\Block $block
 */

$displaName = [
  'css'  => 'CSS',
  'html' => 'HTML',
  'js'   => 'JavaScript',
];

$language = $block->language()->or('text')->value();

?>
<div class="Code">
  <div class="Code-language text-bold"><?= $displaName[$language] ?? $language ?></div>
  <div class="Code-example">
    <pre><code class="language-<?= $language ?>"><?= $block->code()->html(false) ?></code></pre>
  </div>
</div>
