@extends('template.main')

@section('title', 'Nom de liste')

@section('mid-content')
<div class="list-detail">
	<div class="list-header">
	  <h1>Gin Tonic<div>20,07€</div></h1>
	  <h5>par Camille<button class="btn btn-default">Ajouter au panier</button></h5>
	  <h6>
	    <span class="label label-default">Jardinage</span>
						<span class="label label-default">Sport</span>
						<span class="label label-default">Bricolage</span>
						<span class="label label-default">Cuisine</span>
						<span class="label label-default">Escalade</span>
	  </h6>
	  <p>
	    Le gin tonic est un cocktail alcoolisé à base de gin et d'eau tonique, parfois accompagné avec une tranche de citron ou de citron vert, et servi avec de la glace
	  </p>
	</div>
	<section class="cards-container">

	  <div class="card">
	    <div class="card-snapshots">
	      <img src="images/content/Cocktails_Gin/indian-tonic.jpg"/>
	    </div>
	    <div class="card-body">
	      <h4>Gin Tonic</h4>
	      <p>Le gin tonic est un cocktail alcoolisé à base de gin et d'eau tonique, parfois accompagné avec une tranche de citron ou de citron vert, et servi avec de la glace.</p>
	    </div>
	    <div class="card-footer">
	      <div class="card-price" rowspan="2">20,07 €</div>
	    </div>
	  </div>

	</section>
</div>
@endsection