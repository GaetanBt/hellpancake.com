<?php

return [
  'ku.yes' => 'Oui',
  'ku.no' => 'Non',

  // Page SEO tab
  'ku.page.seo.tab' => 'SEO',
  'ku.page.seo.meta_headline' => 'Metadonnées de la page',
  'ku.page.seo.meta_title' => 'Titre',
  'ku.page.seo.meta_title.help' => 'Laisser vide pour utiliser le nom de la page.',
  'ku.page.seo.meta_description' => 'Description',
  'ku.page.seo.meta_description.help' => 'Laisser vide pour utiliser le début du contenu de la page s\'il existe.',
  'ku.page.seo.configuration_headline' => 'Configuration',
  'ku.page.seo.is_translated' => 'La page est traduite',
  'ku.page.seo.meta_robots_index' => 'Indexer la page ?',

  // Site SEO tab
  'ku.site.seo.tab' => 'SEO',
  'ku.site.seo.meta_headline' => 'Metadonnées du site',
  'ku.site.seo.meta_title_separator' => 'Séparateur entre le titre de la page et le nom du site',
  'ku.site.seo.meta_title_separator_help' => 'Laisser vide pour utiliser le séparateur fourni par défaut : {{ kirby.option("GaetanBt.kirby-utilities.seo.metaTitleSeparator") }}',
  'ku.site.seo.meta_description_from_excerpt_length' => 'Longueur de la description générée par défaut',
  'ku.site.seo.meta_description_from_excerpt_length_help' => 'Laisser vide pour utiliser le nombre de caractères fourni par défaut : {{ kirby.option("GaetanBt.kirby-utilities.seo.metaDescriptionFromExcerptLength") }}',
  'ku.site.seo.robots_txt_headline' => 'Robots.txt',
  'ku.site.seo.robots_txt_info' => 'Voir <a href="https://github.com/ai-robots-txt/ai.robots.txt">le projet ai.robots.txt sur GitHub</a> qui recense les bots connus d\'Intelligence Artificielle.',
  'ku.site.seo.bots_to_exclude' => 'Liste des robots à exclure',
  'ku.site.seo.bots_to_exclude.name' => 'Nom',

  // Site feed tab
  'ku.site.feed.tab' => 'Flux',
  'ku.site.feed.atom_headline' => 'Configuration du flux Atom',
  'ku.site.feed.atom_title' => 'Titre du flux Atom',
  'ku.site.feed.atom_subtitle' => 'Sous-titre du flux Atom',

  // User metas blueprints
  'ku.user.metas' => 'Informations personnelles',
  'ku.user.metas.help' => 'Ces informations sont utilisées par le plugin Kirby Utilities pour la génération du flux Atom et l\'affichage des articles.',
  'ku.user.website' => 'Site web',
  'ku.user.public_name' => 'Nom public',
  'ku.user.public_name.help' => 'Laisser vide pour utiliser le nom du compte',
  'ku.user.public_email' => 'Email public',
  'ku.user.public_email.help' => 'Laisser vide pour utiliser l\'email du compte',
  'ku.user.display_email_on_website' => 'Afficher l\'email sur le site',
  'ku.user.display_email_in_sitemap' => 'Afficher l\'email dans le sitemap.xml',
];
