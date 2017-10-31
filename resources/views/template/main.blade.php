@extends('template.master')

@section('main')
<main class="row">
  <div class="col-xs-12">
		<div id="search-region" class="row form-group">
      <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
        <h1>Recherche de liste par tags</h1>
        <h4>Saisissez des termes en rapport avec ce qu'il vous faut.</h4>
        <form>
					<input type="text" class="tags-input form-control" placeholder="Entrez un tag..." />
          <button tabindex="1" title="Rechercher des listes en fonction des tags entrés"><span class='glyphicon glyphicon-search'></span></button>
        </form>
				<h6>Tags populaires :
					<span class="label label-default popular-tag">Jardinage</span>
					<span class="label label-default popular-tag">Sport</span>
					<span class="label label-default popular-tag">Bricolage</span>
					<span class="label label-default popular-tag">Cuisine</span>
					<span class="label label-default popular-tag">Escalade</span>
				</h6>
			</div>
		</div>

    <!-- Dynamic content loaded in #mid-content -->
    @yield('mid-content')

  </div>
</main>
@endsection