@extends('template.master')

@section('title', 'Création de liste')

@section('main')

<div class="row creation">
  <div id="step-one">
    <h1 style="text-align: center">Etape 1 : Sélectionnez vos produits</h1>

    <div class="col-md-6 col-md-offset-3" style="padding: 10px; background-color: #FFFFFF">
      <h2>Pas encore de produits</h2>
      <div class="form-steps">
        <div class="col-md-offset-5">
          <button type="button">Etape suivante</button>
        </div>
      </div>
    </div></br>

    <div class="col-md-6 col-md-offset-3" style="padding: 10px; margin-top: 3%; background-color: #FFFFFF">
      <div class="col-xs-12">
        <div id="search-region" class="row form-group">
          <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
            <h1>Recherche de produits</h1>

            <input type="text" id="search-bar" class="form-control" placeholder="Entrez un nom de produit..."/>
            <button id="go-search" tabindex="1" title="Rechercher des produits">Rechercher</button>
          </div>
        </div>
        <div id="search-result">

        </div>
      </div>
    </div>

  </div>


</div>

@endsection
