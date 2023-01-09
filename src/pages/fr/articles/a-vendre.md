---
meta:
  title: Je vends mes jeux de société
date: "2022-11-07"
lastUpdated: "2023-01-09"
excerpt: Je mets en vente quelques jeux de société pour faire un peu de place.
---

# Je vends mes jeux de société

Je n'ai plus l'occasion d'y jouer autant que je le souhaite alors je préfère mettre en vente une partie de ma collection.
Ils seront certainement mieux entre vos mains qu'à décorer mon étagère.

Ils sont tous en excellent état, j'en ai toujours pris soin et fait attention aux boites et à leur contenu. Je vous envoie bien évidemment des photos si vous êtes intéressé·e.

Sauf mention contraire, tous les jeux sont en français, complets et les cartes (s'il y en a et que les jeux ont été joués) sont protégées par des <i lang="en">sleeves</i>. Elles sont donc dans un état neuf.
Je privilégie les ventes groupées de jeux + leur(s) extension(s) si je les ai. J'ai défini les prix rapidement en fonction des tendances sur Okkazeo et/ou LeBonCoin.

Vous pouvez me contacter pour le moment uniquement via Twitter ou Mastodon, les liens sont disponibles sur la page [à propos](/fr/a-propos/). N'hésitez pas si vous avez des questions, mes DMs y sont ouverts.

<div class="table-responsive">
  <table>
    <caption>Mes {{ boardgames | length }} jeux en vente</caption>
    <thead>
      <tr>
        <th scope="col">Nom</th>
        <th scope="col">Nombre de joueurs</th>
        <th scope="col">Commentaire</th>
        <th scope="col">Lien</th>
        <th scope="col">Prix</th>
      </tr>
    </thead>
    <tbody>
      {%- for game in boardgames %}
      <tr>
        <th scope="row">{{ game.name }}</th>
        <td>
          {%- if "-" in game.players -%}
            {{ game.players | replace("-", " à ") }} joueurs
          {%- elseif game.players != "" -%}
            {{ game.players }} joueur{{ "s" if game.players != "1" }}
          {%- endif -%}
        </td>
        <td>{{ game.comment | safe }}</td>
        <td>
          <a href="{{ game.link.href }}" title="Voir {{ game.name }} sur {{ game.link.label }}"><span class="sr-only">Voir {{ game.name }} sur </span>{{ game.link.label }}</a>
        </td>
        <td>{{ game.price }}&nbsp;€</td>
      </tr>
      {%- endfor %}
    </tbody>
  </table>
</div>
