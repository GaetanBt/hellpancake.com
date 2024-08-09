<?php

namespace GaetanBt\Kirby\Utilities\Helpers;

use Kirby\Cms\User;
use Kirby\Content\Content;

class UserHelper
{
  const USER_METAS_FIELD_NAME = 'ku_user_metas';

  public static function metasField(User $user): Content
  {
    return $user->content()->get(self::USER_METAS_FIELD_NAME)->toObject();
  }

  public static function email(User $user): ?string
  {
    $metas_field = self::metasField($user);
    $display_email = $metas_field->display_email_on_website()->toBool();

    if (false === $display_email) {
      return null;
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

  public static function website(User $user): string
  {
    return self::metasField($user)->get('website');
  }
}