@extends('template.master')

@section('main')

    <div class="col-xs-12">
        <div id="search-region" class="row form-group">
            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
                <h1>Recherche de listes par tags</h1>
                <p class="main-text">Saisissez des termes en rapport avec ce qu'il vous faut.</p>
                <form>
                    <input id="tags-input" type="text" class="tags-input form-control" placeholder="Entrez un tag..."/>
                    <input id="research-button" type="submit" tabindex="1" title="Rechercher des listes en fonction des tags entrés" value="" />
                </form>
                <p class="tags-populaires">Tags populaires :
                    @foreach ($tags_final_tab as $tag)
                        <span class="label label-default popular-tag">{{ $tag->tagName }}</span>
                    @endforeach
                </p>
            </div>
        </div>

        <!-- Dynamic content loaded in #mid-content -->
        <div class="mid-content col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
            @yield('mid-content')
        </div>

    </div>

@endsection
