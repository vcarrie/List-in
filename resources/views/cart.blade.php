@extends('template.master')

@section('title', 'Panier')

@section('main')
<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
	<div class="row mid-content cart-master">

		<h1>Mon Panier</h1>

		<table>
			<thead>
				<tr>
					<th colspan="4">Nom liste</th>
					<th class="cart-small">100€</th>
				</tr>
			</thead>
			<tbody>
				@for ($i = 0; $i < 5; $i++)
				<tr>
					<td><img src="" alt="produit"/></td>
					<td>Article 1</td>
					<td>Description</td>
					<td class="cart-small">1</td>
					<td class="cart-small">100€</td>
				</tr>
				@endfor
			</tbody>
			<tfoot>
				<tr>
					<td colspan="5">
						<a href="#" target="blank" class="btn btn-primary" title="Acheter sur CDiscount">Acheter sur CDiscount</a>
						<a href="#" class="btn btn-danger" title="Supprimer">Supprimer</a>
					</td>
				</tr>
			</tfoot>
		</table>

	</div>
</div>

@endsection
