<div class="col-md-10 col-lg-8  col-md-offset-1 col-lg-offset-2">
    <div class="row">

        <nav class="navbar navbar-default" role="navigation">
            <div>

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">
                        <img class="logo img-responsive" src="../../../public/images/Logo_V4_transparent.png"
                             alt="logo listin"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a tabindex="1" href="/catalogue">
                                <img alt="catalogue" src="../../../public/images/icon-catalogue.png"/>
                                <h5>Catalogue</h5>
                            </a>
                        </li>
                        <li>
                            <a tabindex="1" href="/create/list">
                                <img alt="créer une liste" src="../../../public/images/icon-new-list.png"/>
                                <h5>Créer une liste</h5>
                            </a>
                        </li>
                        <li>
                            <a tabindex="1" href="#">
                                <img alt="mon panier" src="../../../public/images/icon-basket.png"/>
                                <h5>Mon Panier</h5>
                            </a>
                        </li>


                        @guest
                            <li>
                                <a href="{{ route('login') }}" tabindex="1">
                                    <img alt="connexion" src="../../../public/images/icon-account.png"/>
                                    <h5>Se connecter</h5>
                                </a>

                            </li>
                        @else
                                <li>
                                    <a tabindex="1" href="#">
                                        <img alt="mon compte" src="../../../public/images/icon-account.png"/>
                                        <h5>Mon Compte</h5>
                                    </a>
                                </li>
                            <!--
                                    <li>
                                     <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                         <img alt="mon compte" src="../../../public/images/icon-deconnexion.png"/>
                                         <h5>Se déconnecter</h5>
                                     </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    </li>
                                -->
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
