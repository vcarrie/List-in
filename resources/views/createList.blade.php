@extends('template.master')

@section('title', 'Création de liste')

@section('main')

    <div class="row" style="margin-top: 3%">
        <h1 style="text-align: center">Etape 1 : Sélectionnez vos produits</h1>

        <div class="col-md-6 col-md-offset-3" style="padding: 10px; background-color: #FFFFFF">
            <h2>Pas encore de produits</h2>

            <div class="form-group">
                <div class="col-md-offset-5">
                    <form action="" >
                        <input type="submit" value="Etape suivante">
                    </form>
                </div>
            </div>

        </div>
        </br>

        <div class="col-md-6 col-md-offset-3" style="padding: 10px; margin-top: 3%; background-color: #FFFFFF">
            <div class="col-xs-12">
                <div id="search-region" class="row form-group">
                    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                        <h1>Recherche de produits</h1>

                        <form>
                            <input type="text" class="tags-input form-control" placeholder="Entrez un nom de produit..."/>
                            <button tabindex="1" title="Rechercher des produits">
                                <span class='glyphicon glyphicon-search'></span>
                            </button>
                        </form>

                    </div>
                </div>

                <!-- Dynamic content loaded in #mid-content -->
                <div class="mid-content col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
                    @yield('mid-content')
                </div>

            </div>
        </div>

    </div>

@endsection