<?php

namespace GaetanBt\Kirby\Utilities\Helpers;

use Kirby\Cms\User;
use Kirby\Content\Content;
use GaetanBt\Kirby\Utilities\Enum\UserInfoDestination;

class UserHelper
{
  const USER_METAS_FIELD_NAME = 'ku_user_metas';

  private static function metasField(User $user): Content
  {
    return $user->content()->get(self::USER_METAS_FIELD_NAME)->toObject();
  }

  public static function email(User $user, UserInfoDestination $destination): ?string
  {
    $metas_field = self::metasField($user);

    switch ($destination) {
      case UserInfoDestination::SitemapXML:
        if (false === $metas_field->display_email_in_sitemap()->toBool()) {
          return null;
        }
        break;
      case UserInfoDestination::Website:
        if (false === $metas_field->display_email_on_website()->toBool()) {
          return null;
        }
        break;
    }

    $public_email = $metas_field->get('public_email');

    if ($public_email->isNotEmpty()) {
      return $public_email;
    }

    return $user->email();
  }

  public static function name(User $user): string
  {
    $public_name = self::metasField($user)->get('public_name');

    if ($public_name->isNotEmpty()) {
      return $public_name;
    }

    return $user->username();
  }

  public static function website(User $user, UserInfoDestination $destination): ?string
  {
    $metas_field = self::metasField($user);

    switch ($destination) {
      case UserInfoDestination::SitemapXML:
        if (false === $metas_field->display_website_in_sitemap()->toBool()) {
          return null;
        }
        break;
      case UserInfoDestination::Website:
        if (false === $metas_field->display_website_on_website()->toBool()) {
          return null;
        }
        break;
    }

    $website = $metas_field->get('website');

    if ($website->isNotEmpty()) {
      return $website;
    }

    return null;
  }
}
