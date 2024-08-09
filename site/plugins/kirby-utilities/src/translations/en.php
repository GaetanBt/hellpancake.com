<?php

return [
  'ku.yes' => 'Yes',
  'ku.no' => 'No',

  // Page SEO tab
  'ku.page.seo.tab' => 'SEO',
  'ku.page.seo.meta_headline' => 'Page metadata',
  'ku.page.seo.meta_title' => 'Title',
  'ku.page.seo.meta_title.help' => 'Leave empty to use the page name.',
  'ku.page.seo.meta_description' => 'Description',
  'ku.page.seo.meta_description.help' => 'Leave empty to use the beginning of the page content if it exists.',
  'ku.page.seo.configuration_headline' => 'Configuration',
  'ku.page.seo.is_translated' => 'Page is translated',
  'ku.page.seo.meta_robots_index' => 'Index page?',

  // Site SEO tab
  'ku.site.seo.tab' => 'SEO',
  'ku.site.seo.meta_headline' => 'Site metadata',
  'ku.site.seo.meta_title_separator' => 'Separator between the page title and the site name',
  'ku.site.seo.meta_title_separator_help' => 'Leave empty to use the default provided separator: {{ kirby.option("GaetanBt.kirby-utilities.seo.metaTitleSeparator") }}',
  'ku.site.seo.meta_description_from_excerpt_length' => 'Generated meta description length',
  'ku.site.seo.meta_description_from_excerpt_length_help' => 'Leave empty to use the default characters length: {{ kirby.option("GaetanBt.kirby-utilities.seo.metaDescriptionFromExcerptLength") }}',
  'ku.site.seo.robots_txt_headline' => 'Robots.txt',
  'ku.site.seo.robots_txt_info' => 'See <a href="https://github.com/ai-robots-txt/ai.robots.txt">the ai.robots.txt project on GitHub</a> that lists known Artificial Intelligence bots.',
  'ku.site.seo.bots_to_exclude' => 'Bots to exclude list',
  'ku.site.seo.bots_to_exclude.name' => 'Name',

  // Site feed tab
  'ku.site.feed.tab' => 'Feed',
  'ku.site.feed.atom_headline' => 'Atom feed configuration',
  'ku.site.feed.atom_title' => 'Atom feed title',
  'ku.site.feed.atom_subtitle' => 'Atom feed subtitle',

  // User metas blueprints
  'ku.user.metas' => 'Personal informations',
  'ku.user.metas.help' => 'These informations are used for the Atom feed generation and on the post pages.',
  'ku.user.website' => 'Website',
  'ku.user.public_name' => 'Public name',
  'ku.user.public_name.help' => 'Leave empty to use the account name',
  'ku.user.public_email' => 'Public email',
  'ku.user.public_email.help' => 'Leave empty to use the account email',
  'ku.user.display_email_on_website' => 'Display email on website',
  'ku.user.display_email_in_sitemap' => 'Display email in sitemap.xml',
];
