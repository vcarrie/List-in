@extends('template.master')

@section('title', 'Création de liste')

@section('main')

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js">
      function test(){
        $.ajax({
          url: "/getproductbykeyword",
          data: {
            search: "Ballon"
          },
          dataType: "json",
          success: function(data){
            console.log(data);
          },
          error: function(){
            console.log("erreuuur");
          },
          method: "POST"
        });
      };
    </script>

    <div class="row creation">
        <h1 style="text-align: center">Etape 1 : Sélectionnez vos produits</h1>

        <div class="col-md-6 col-md-offset-3" style="padding: 10px; background-color: #FFFFFF">
            <h2>Pas encore de produits</h2>

            <section class="article-container">
                <div class="article">
                    <div class="article-snapshots">
                        <img src="../../public/images/content/Cocktails_Gin/indian-tonic.jpg"/>
                    </div>
                    <div class="article-body">
                        <h4 title="Gin Tonic">Gin Tonic</h4>
                        <p>Le gin tonic est un cocktail alcoolisé à base de gin et d'eau tonique, parfois accompagné avec une
                            tranche de citron ou de citron vert, et servi avec de la glace.</p>
                    </div>
                    <div class="article-footer">
                        <table>
                            <tr>
                                <td class="article-price" rowspan="2">20,07 €</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </section>

            <div class="form-steps">
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
                            <input type="text" id="search-bar" class="form-control" placeholder="Entrez un nom de produit..."/>
                            <button id="testButton" onclick="test()" tabindex="1" title="Rechercher des produits">
                                <span class='glyphicon glyphicon-search'></span>
                            </button>
                        </form>
                    </div>
                </div>
                <div id="search-result">
                  <p>
                    Affichage des produits ici
                  </p>
                </div>
            </div>
        </div>

    </div>

@endsection
