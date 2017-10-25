

<main class="row">
  <div class="col-xs-12">
    <div id="lists-filter" class="row form-group">
      <h1>Recherchez des listes !</h1>
      <div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
        <form>
          <input type="text" class="tags-filter form-control" placeholder="Entrez un tag..." />
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
    <div id="mid-content" class="col-md-8 col-md-offset-2">
      @yield('mid-content')
    </div>

  </div>
</main>
