@extends('template.master')

@section('title', 'Création de liste')

@section('main')

    <div class="row creation">

        <form id="list-creation" method="post">
            {{ csrf_field() }}
            <div id="step-one">
                <h1>Etape 1 : Sélectionnez vos produits</h1>
                <div id="articles-container" class="panel panel-default col-md-6 col-md-offset-3 mid-content">
                    <div class="panel-heading"><strong>Vos produits</strong></div>
                    <h2 class="no-article">Aucun produit ajouté</h2>
                    <div id="selected-articles" class="cards-container">

                    </div>
                    <div class="form-steps">
                        <div class="next_step_button">
                            <button id="next-step" class="btn btn-secondary" type="button" disabled="true">Etape suivante</button>
                        </div>
                    </div>
                </div>
                <br>

                <div id="search-products" class="panel panel-default col-md-6 col-md-offset-3">
                    <div class="panel-heading"><strong>Recherchez des produits</strong></div>
                    <div class="col-md-6 col-md-offset-3">
                        <input id="search-bar" type="text" class="form-control" placeholder="Entrez un nom de produit..."/>
                        <div class="search_button">
                            <button id="go-search" class="btn btn-secondary" tabindex="1" title="Rechercher des produits">Rechercher</button>
                        </div>
                    </div>
                    <div id="result-region" class="col-md-12">

                    </div>
                </div>

            </div>

            <div id="step-two" style="display: none;">
                <h1>Etape 2 : Validez votre liste</h1>
                <div id="info-container" class="panel panel-default col-md-6 col-md-offset-3">
                    <div class="panel-heading"><strong>Informations de la liste</strong></div>
                    <div class="col-md-offset-2">
                        <label for="list_name" class="l_name">Nom de la liste :</label><br>
                        <input id="list_name" class="bootstrap-tagsinput" type="text" name="list_name" placeholder="Nom de la liste..."><br>
                        <label for="list" class="desc">Description :</label><br>
                        <label for="list_description"></label><textarea id="list_description" name="list_description" rows="6" cols="60"></textarea><br>

                        <div id="tag-search" class="row form-group">
                            <div class="col-md-6 " style="padding: 0%">
                                <form>
                                    <label for="list_tag" class="tag">Tags de la liste :</label><br>
                                    <input id="selected_tag" type="text" class="tags-input form-control"
                                           placeholder="Entrez un tag..."/>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="recap-container" class="panel panel-default col-md-6 col-md-offset-3">
                    <div class="panel-heading"><strong>Récapitulatif de la liste</strong></div>
                    <div id="recap-articles">

                    </div>
                    <div id="total-price-container" class="col-md-offset-9">
                      Total : </br>
                      <strong id="total-price"></strong>
                    </div>
                    <div class="validate-container">
                        <button id="previous-step" class="btn btn-secondary"type="button">Etape précédente</button>
                        <input id="list_validate" class="btn btn-secondary" type="submit" name="create_list" value="Valider">
                    </div>
                </div>
                <div id="hidden-container">

                </div>

            </div>
        </form>

    </div>

@endsection
