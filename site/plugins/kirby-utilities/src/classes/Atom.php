<?php

/**
 * Very much inspired by https://github.com/aschmelyun/basic-feeds
 */

namespace GaetanBt\Kirby\Utilities;

use GaetanBt\Kirby\Utilities\Exceptions\MissingRequiredAttributeException;

class Atom
{
  public string $languageCode;

  public array $attributes;

  public array $requiredFeedAttributes = [
    'link',
    'title',
    'updated',
  ];

  public array $requiredEntryAttributes = [
    'link',
    'title',
    'updated',
  ];

  public \SimpleXMLElement $xml;

  public function __construct(string $languageCode, array $attributes)
  {
    $this->languageCode = $languageCode;
    $this->attributes = $attributes;

    $this->init();
  }

  public function init(): self
  {
    $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><feed xml:lang="' . $this->languageCode . '" xmlns="http://www.w3.org/2005/Atom"></feed>');
    $this->addFeedDefinitions();

    return $this;
  }

  public function addFeedDefinitions(): self
  {
    $attributes = $this->attributes;

    foreach ($this->requiredFeedAttributes as $required) {
      if (false === isset($attributes[$required])) {
        throw new MissingRequiredAttributeException('Missing required feed attribute: ' . $required);
      }
    }

    if (false === isset($attributes['id'])) {
      $attributes['id'] = $attributes['link'];
    }

    $link = $this->xml->addChild('link');
    $link->addAttribute('href', $attributes['link']);

    $feedLink = $this->xml->addChild('link');
    $feedLink->addAttribute('href', $attributes['feedUrl']);
    $feedLink->addAttribute('rel', 'self');

    if (isset($attributes['author'])) {
      $author = $this->xml->addChild('author');

      foreach ($attributes['author'] as $name => $value) {
        $author->addChild($name, $value);
      }

      unset($attributes['author']);
    }

    unset(
      $attributes['link'],
      $attributes['feedUrl']
    );

    foreach ($attributes as $name => $value) {
      $this->xml->addChild($name, $value);
    }

    return $this;
  }

  public function entry(array $attributes): self
  {
    foreach ($this->requiredEntryAttributes as $required) {
      if (false === isset($attributes[$required])) {
        throw new MissingRequiredAttributeException('Missing required entry attribute: ' . $required);
      }
    }

    if (false === isset($attributes['id'])) {
      $attributes['id'] = $attributes['link'];
    }

    $entry = $this->xml->addChild('entry');

    $link = $entry->addChild('link');
    $link->addAttribute('href', $attributes['link']);

    if (isset($attributes['author'])) {
      $author = $entry->addChild('author');

      foreach ($attributes['author'] as $name => $value) {
        if (null === $value) continue;
        $author->addChild($name, $value);
      }

      unset($attributes['author']);
    }

    unset($attributes['link']);

    foreach ($attributes as $name => $value) {
      $entry->addChild($name, $value);
    }

    return $this;
  }

  public function generate(): string
  {
    return $this->xml->asXML();
  }

  public function render(): void
  {
    echo $this->generate();
  }
}
