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

  public array $entries;

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

  public function __construct(string $languageCode, array $attributes = [])
  {
    $this->languageCode = $languageCode;
    $this->attributes = $attributes;

    $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><feed xml:lang="' . $this->languageCode . '" xmlns="http://www.w3.org/2005/Atom"></feed>');
  }

  public function updated(string $value): self
  {
    $this->attributes['updated'] = $value;

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

  public function addFeedEntries(): self
  {
    foreach ($this->entries as $entry) {
      $xml = $this->xml->addChild('entry');

      $link = $xml->addChild('link');
      $link->addAttribute('href', $entry['link']);

      if (isset($entry['author'])) {
        $author = $xml->addChild('author');

        foreach ($entry['author'] as $name => $value) {
          if (null === $value) continue;
          $author->addChild($name, $value);
        }

        unset($entry['author']);
      }

      unset($entry['link']);

      foreach ($entry as $name => $value) {
        $xml->addChild($name, $value);
      }
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

    $this->entries[] = $attributes;

    return $this;
  }

  public function generate(): string
  {
    $this->addFeedDefinitions();
    $this->addFeedEntries();

    return $this->xml->asXML();
  }

  public function render(): void
  {
    echo $this->generate();
  }
}
