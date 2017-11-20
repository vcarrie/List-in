@extends('template.master')

@section('title', 'Mon Compte')

@section('main')

<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
	<img alt="mon compte" src="../../../public/images/icon-deconnexion.png"/>
	<h5>Se déconnecter</h5>
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>

@endsection