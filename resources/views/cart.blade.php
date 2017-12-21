@extends('template.master')

@section('title', 'Panier')

@section('main')
<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
	<div class="row mid-content cart-master">

		<h1>Mon Panier</h1>
		@for ($i = 0; $i < count($to_return)-1; $i++)
		<table id="cart-list-{{ $to_return[$i][0]->id }}">
			<thead>
				<tr>
					<th colspan="3">{{ $to_return[$i][0]->listName }}</th>
					<th colspan="2" class="no-wrap">{{ $to_return[$i][3] }} €</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($to_return[$i][1] as $product)
				<tr>
					<td><img src="{{ $product[0]->Products[0]->MainImageUrl }}" alt="produit"/></td>
					<td>{{ $product[0]->Products[0]->Name }}</td>
					<td class="hidden-xs">{{ $product[0]->Products[0]->Description }}</td>
					<td class="visible-xs"></td>
					<td class="no-wrap">× {{ $product[1] }}</td>
					@if (isset($product[0]->Products[0]->BestOffer))
						<td class="no-wrap">{{ round($product[0]->Products[0]->BestOffer->SalePrice, 2) }} €</td>
					@else
						<td class="no-wrap">Plus en stock</td>
					@endif
					</tr>
				@endforeach
			</body>
			<tfoot>
				<tr>
					<td colspan="5">
						<a href="#" data-listid="{{ $to_return[$i][0]->id }}" class="delete-list btn btn-danger" title="Supprimer">Supprimer</a>
					</td>
				</tr>
			</tfoot>
		</table>
		@endfor
		<div class="cart-footer">
			@if (count($to_return)>1)
				<a href="{{ $to_return[count($to_return)-1] }}" target="blank" class="btn btn-lg btn-primary" title="Acheter sur CDiscount">Acheter sur CDiscount</a>
			@else
				<p>Panier vide.</p>
			@endif
		</div>
	</div>
</div>

@endsection
