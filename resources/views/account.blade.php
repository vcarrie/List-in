@extends('template.master')

@section('title', 'Mon Compte')

@section('main')

<div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-offset-3">
	<div class="row mid-content account-master">

		<nav class="col-sm-3">
			<ul class="nav nav-pills nav-stacked">
				<li class="active"><a data-toggle="tab" href="#account-section-1">Informations</a></li>
				<li><a data-toggle="tab" href="#account-section-2">Sécurité</a></li>
				<li><a data-toggle="tab" href="#account-section-3">Mes listes</a></li>
				<!--<li><a data-toggle="tab" href="#account-section-4">Historique</a></li>-->
			</ul>
		</nav>

		<div class="col-sm-9 tab-content">
			
			<section class="row tab-pane fade in active" id="account-section-1">
				<div class="col-xs-12">
					<h2>Informations</h2>
				</div>
				<div class="col-xs-12">
					<p>{{ $to_return[0]->firstName }} {{ $to_return[0]->lastName }} ({{ $to_return[0]->pseudo }})</p>
					<p>{{ $to_return[0]->email }}</p>
					<p>Inscrit le : date</p>
					<p>Dernière connexion : date</p>
				</div>
			</section>

			<section class="row tab-pane fade" id="account-section-2">
				<div class="col-xs-12">
					<h2>Sécurité</h2>
				</div>
				<div class="col-xs-12">
					<form>
						<fieldset>
							<legend>Changer votre mot de passe</legend>
							<div class="form-group">
								<label>Mot de passe actuel:</label>
								<input class="form-control" type="password" name="old_pwd" />
							</div>
							<div class="form-group">
								<label>Nouveau mot de passe:</label>
								<input class="form-control" type="password" name="new_pwd1" />
							</div>
							<div class="form-group">
								<label>Confirmez le mot de passe:</label>
								<input class="form-control" type="password" name="new_pwd1" />
							</div>
							<input class="btn btn-default pull-right" type="submit" value="Confirmer"/>
						</fieldset>
					</form>
				</div>
				<div class="col-xs-12">
					<form>
						<fieldset>
							<legend>Changer votre email</legend>
							<div class="form-group">
								<label>Email actuel:</label>
								<input class="form-control" type="password" name="old_email" />
							</div>
							<div class="form-group">
								<label>Nouvel email:</label>
								<input class="form-control" type="password" name="new_email1" />
							</div>
							<div class="form-group">
								<label>Confirmez l'email:</label>
								<input class="form-control" type="password" name="new_email2" />
							</div>
							<input class="btn btn-default pull-right" type="submit" value="Confirmer"/>
						</fieldset>
					</form>
				</div>
			</section>

			<section class="row tab-pane fade" id="account-section-3">
				<div class="col-xs-12">
					<h2>Mes listes ({{ count($to_return[1]) }})</h2>
				</div>
				@if (count($to_return[1]) === 0)
				<div class="col-xs-12">
					<h3>Vous n'avez pas encore créé de liste.</h3>
					<a href="/create/list">Créer une liste</a>
				</div>
				@else
				<div class="col-xs-12">
					@for ($i = 0; $i < count($to_return[1]); $i++)
					<div class="row list-resume">
						<div class="col-sm-9">
							<h4><a href="/list/{{ $to_return[1][$i][0]['id'] }}">{{ $to_return[1][$i][0]['listName'] }}</a></h4>
							<div class="hidden-xs list-figures">
								@foreach ($to_return[1][$i][1] as $product)
								<figure>
									<img src="{{ $product[0]->Products[0]->MainImageUrl }}" alt="produit"/>
									<figcaption>
										{{ $product[0]->Products[0]->Name }}
									</figcaption>
								</figure>
								@endforeach
							</div>
						</div>
						<div class="col-sm-3">
							<button class="btn btn-danger">Supprimer</button>
						</div>
					</div>
					@endfor
				</div>
				@endif
			</section>

			<!--<section class="row tab-pane fade" id="account-section-4">
				<div class="col-xs-12">
					<h2>Historique</h2>
				</div>
			</section>-->

		</div>

	</div>
</div>
@endSection
<!--
<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
	<img alt="mon compte" src="../../../public/images/icon-deconnexion.png"/>
	<h5>Se déconnecter</h5>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
-->

