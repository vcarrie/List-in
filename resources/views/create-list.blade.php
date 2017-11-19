@extends('template.master')

@section('title', 'Création de liste')

@section('main')

    <div class="row creation">

        <form id="list-creation" method="post">
            {{ csrf_field() }}
            <div id="step-one">
                <h1 class="title-create-list">Etape 1 : Sélectionnez vos produits</h1>
                <div id="articles-container" class="col-md-6 col-md-offset-3"
                     style="padding: 10px; background-color: #FFFFFF">
                    <h2 class="no-article">Pas encore de produits</h2>
                    <div id="selected-articles">

                    </div>
                    <div class="form-steps">
                        <div class="col-md-offset-5">
                            <button class="btn btn-next-step" id="next-step" type="button">Etape suivante</button>
                        </div>
                    </div>
                </div>
                <br>

                <div class="research-product col-md-6 col-md-offset-3">
                    <div class="col-xs-12">
                        <div id="search-region" class="row form-group">
                            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                                <h1>Recherche de produits</h1>
                                <input class="search-bar" id="search-bar" type="text" class="form-control"
                                       placeholder="Entrez un nom de produit..."/>
                                <button class="btn btn-go-search" id="go-search" tabindex="1" title="Rechercher des produits">Rechercher</button>
                            </div>
                        </div>
                        <div id="result-region">

                        </div>
                    </div>
                </div>
            </div>

            <div id="step-two" style="display: none;">
                <h1 class="title-create-list">Etape 2 : Validez votre liste</h1>
                <div id="info-container" class="col-md-6 col-md-offset-3">
                    <label for="list_name" class="name-list">Nom de la liste :</label><br>
                    <input id="list_name" class="name_liste" type="text" name="list_name" placeholder="Nom de la liste..."><br>
                    <label for="" class="description-list">Description :</label><br>
                    <label for="list_description"></label><textarea class="description_list" id="list_description" name="list_description" rows="6" cols="60"></textarea><br>

                    <div id="tag-search" class="row form-group">
                        <div class="col-md-6 ">
                            <form>
                                <input id="selected_tag" type="text" class="tags-input form-control"
                                       placeholder="Entrez un tag..."/>
                                <input class="btn btn-add-tags" id="add_tag" type="submit" tabindex="1" title="Ajouter un tag" value="Ajouter"/>
                            </form>
                        </div>
                    </div>
                    <button class="previous-step" id="previous-step" type="button">Etape précédente</button>
                </div>

                <div id="recap-container" class="col-md-6 col-md-offset-3"
                     style="padding: 10px; background-color: #FFFFFF">
                    rejdhbsjbn
                </div>

                <input type="submit" name="create_list" value="Valider">
            </div>
        </form>

    </div>

@endsection
