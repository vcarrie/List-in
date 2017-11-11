@extends('template.master')

@section('title', 'Authentification')

@section('main')
<div class="col-xs-12">
	<div class="row">
		<form class="col-xs-6" action="/public/auth/login" method="post">
		    {{ csrf_field() }}


		    {{ $auth }}
		    <input type="text" name="mail"> <br>
		    <input type="password" name="password"><br>
		    <input type="submit" value="connexion">
		</form>

		<form class="col-xs-6" action="/public/auth/register" method="post">
		    {{ csrf_field() }}
		    Pseudo <input type="text" name="pseudo"> <br>
		    Prénom <input type="text" name="firstName"> <br>
		    Nom<input type="text" name="lastName"> <br>
		    Mail<input type="text" name="email"> <br>
		    Mot de passe <input type="password" name="password"> <br>
		    <input type="submit" value="m'inscrire"><br>
		</form>
	</div>
</div>
@endsection