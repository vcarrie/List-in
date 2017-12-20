@extends('template.master')

@section('title', 'Panier')

@section('main')
<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
	<div class="row mid-content cart-master">

		<h1>Mon Panier</h1>
		<pre>
			@foreach ($to_return as $list)
				<?php var_dump($list[0]->$attributes); ?>
			@endforeach
		</pre>
		<table id="foobar">
			<thead>
				<tr>
					<th colspan="3">Kit de relaxation ambiante</th>
					<th colspan="2" class="no-wrap">11,95 €</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><img src="http://i2.cdscdn.com/pdt2/0/8/4/1/300x300/3662143014084.jpg" alt="produit"/></td>
					<td>Bougie parfumée Senteur bois de santal - 6x10cm</td>
					<td class="hidden-xs">Bougie parfumée Senteur bois de santal - 6x10cm</td>
					<td class="visible-xs"></td>
					<td class="no-wrap">× 2</td>
					<td class="no-wrap">3,49 €</td>
				</tr>
				<tr>
					<td><img src="http://i2.cdscdn.com/pdt2/0/1/7/1/300x300/COD6BAT017.jpg" alt="produit"/></td>
					<td>20 Bâtons d'encens Relaxation brun</td>
					<td class="hidden-xs">Bâtons d'encens 100% naturel vendus en lot de 20 au parfum de relaxation. Dimensions : 30,5x6,3x0,8 cm. Un cadeau original avec des encens purs et naturels de haute qualité.</td>
					<td class="visible-xs"></td>
					<td class="no-wrap">×̣ 1</td>
					<td class="no-wrap">0,99 €</td>
				</tr>
				<tr>
					<td><img src="http://i2.cdscdn.com/pdt2/0/1/3/1/300x300/COD6CNE013.jpg" alt="produit"/></td>
					<td>20 Cônes d'encens Relaxation brun</td>
					<td class="hidden-xs">Cônes d'encens 100% naturel vendus en lot de 20 au parfum de relaxation. Dimensions : 12,3x7x1,7 cm. Un cadeau original avec des ingrédients purs et naturels de haute qualité.</td>
					<td class="visible-xs"></td>
					<td class="no-wrap">× 1</td>
					<td class="no-wrap">0,99 €</td>
				</tr>
				<tr>
					<td><img src="http://i2.cdscdn.com/pdt2/1/0/2/1/300x300/COD6HUI102.jpg" alt="produit"/></td>
					<td>Set 3 parfums d'ambiance brun</td>
					<td class="hidden-xs">Set de 3 parfums d'ambiance 100% naturel de coloris brun. L'association de la relaxation, lotus et sérénité s'accorde en harmonie avec chaque ambiance. Dimensions : 9x8x2,5 cm.</td>
					<td class="visible-xs"></td>
					<td class="no-wrap">× 1</td>
					<td class="no-wrap">2,99 €</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<a style="cursor:not-allowed;" onclick="event.preventDefault();"  href="#" target="blank" class="btn btn-primary" title="Acheter sur CDiscount">Acheter sur CDiscount</a>
						<a href="#" data-listid="foobar" class="delete-list btn btn-danger" title="Supprimer">Supprimer</a>
					</td>
				</tr>
			</tfoot>
		</table>

	</div>
</div>

@endsection
