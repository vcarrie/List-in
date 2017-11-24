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
                    <a class="navbar-brand" href="/" title="Accueil">
                        <img class="logo img-responsive" src="../../../public/images/Logo_V4_transparent.png"
                             alt="logo listin"/>
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a tabindex="1" href="/catalogue">
                                <img alt="catalogue" src="../../../public/images/icon-catalogue.png"/>
                                <p>Catalogue</p>
                            </a>
                        </li>
                        <li>
                            <a tabindex="1" href="/create/list">
                                <img alt="créer une liste" src="../../../public/images/icon-new-list.png"/>
                                <p>Créer une liste</p>
                            </a>
                        </li>
                        <li>
                            <a tabindex="1" href="{{ route('cart') }}">
                                <img alt="mon panier" src="../../../public/images/icon-basket.png"/>
                                <p>Mon Panier</p>
                            </a>
                        </li>


                        @guest
                            <li>
                                <a href="{{ route('login') }}" tabindex="1">
                                    <img alt="connexion" src="../../../public/images/icon-account.png"/>
                                    <p>Se connecter</p>
                                </a>

                            </li>
                        @else
                            <li class="dropdown">
                                <a class="dropdown-toggle" tabindex="1" href="#" id="dropdown-account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img alt="mon compte" src="../../../public/images/icon-account.png"/>
                                    <p>Mon Compte</p>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-account">
                                    <li>
                                        <a href="/account">Paramètres</a>
                                    </li>
                                    <li>
                                        <a onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="dropdown-item" href="{{ route('logout') }}">Déconnexion</a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
