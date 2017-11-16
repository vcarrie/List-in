@extends('template.main')

@section('title', 'Catalogue')

@section('mid-content')

<aside>
  <h3>Il y a 12 listes associées aux tags "..."</h3>
  <p>Trier par
    <select name="sorting_mode" class="selectpicker">
      <option value="0">Meilleures notes</option>
      <option value="1">Prix croissant</option>
      <option value="2">Prix décroissant</option>
      <option value="3">Moins d'articles</option>
      <option value="4">Plus d'articles</option>
    </select>
  </p>
</aside>

<section class="cards-container">
  <div class="card">
    <div class="card-header">
      <div class="star-ratings-sprite"><span style="width: 55%" class="star-ratings-sprite-rating"></span>
      </div>
    </div>
    <div class="card-snapshots">
      <img src="../../public/images/content/Cocktails_Gin/indian-tonic.jpg"/>
      <img src="../../public/images/content/Cocktails_Gin/gin-37-5deg-gordon-s-london-dry-70cl.jpg"/>
      <img src="../../public/images/content/Cocktails_Gin/bjorg-pur-jus-de-citrons-de-sicile-25cl.jpg"/>
      <span>+2</span>
    </div>
    <div class="card-body">
      <h4 title="Gin Tonic">Gin Tonic</h4>
      <p>Le gin tonic est un cocktail alcoolisé à base de gin et d'eau tonique, parfois accompagné avec une
        tranche de citron ou de citron vert, et servi avec de la glace.</p>
      </div>
      <div class="card-footer">
        <table>
          <tr>
            <td class="card-item-count">3 articles</td>
            <td class="card-price" rowspan="2">20,07 €</td>
          </tr>
          <tr>
            <td class="card-item-count-opt">dont 1 optionnel</td>
          </tr>
        </table>
      </div>
      <button>Voir la liste</button>
      <button>Ajouter au panier</button>
    </div>
  </section>

  <aside>
    <div class="pagination-box">
      <ul class="pagination pagination-lg">
        <li class="disabled"><a href="#">&laquo;</a></li>
        <li><a href="#">&lsaquo;</a></li>
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">&rsaquo;</a></li>
        <li><a href="#">&raquo;</a></li>
      </ul>
    </div>
  </aside>
  @endsection
