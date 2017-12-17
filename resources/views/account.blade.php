@extends('template.master')

@section('title', 'Mon Compte')

@section('main')

    <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2 col-lg-offset-3">
        <div class="row mid-content account-master">

            <nav class="col-sm-3">
                <ul class="nav nav-pills nav-stacked" id="tabAccount">
                    <li class="active"><a data-toggle="tab" href="#account-section-1">Informations</a></li>
                    <li><a data-toggle="tab" href="#account-section-2">Sécurité</a></li>
                    <li><a data-toggle="tab" href="#account-section-3">Mes listes</a></li>
                </ul>
            </nav>

            <div class="col-sm-9 tab-content">

                <section class="row tab-pane fade in active" id="account-section-1">
                    <div class="col-xs-12">
                        <h2>Informations</h2>
                    </div>
                    <div class="col-xs-12">
                        <p>{{ $to_return[0]->firstName }} {{ $to_return[0]->lastName }} ( {{ $to_return[0]->pseudo }} )</p>
                        <p>{{ $to_return[0]->email }}</p>
                        <p>Inscrit le : {{ $to_return[0]->created_at }}</p>
                    </div>
                </section>

                <section class="row tab-pane fade" id="account-section-2">
                    <div class="col-xs-12">
                        <h2>Sécurité</h2>
                    </div>
                    <div class="col-xs-12">
                        <form method="post" action="{{url('/update/user/password')}}">
                            {{csrf_field()}}
                            <fieldset>
                                <legend>Changer votre mot de passe</legend>
                                @if (session('confirmation-success-password'))
                                    <div class="alert alert-success">
                                        {{ session('confirmation-success-password') }}
                                    </div>
                                @endif
                                <div class="form-group {{ $errors->has('old_pwd') ? 'has-error' : '' }}">
                                    <label for="old_pwd">Mot de passe actuel: </label>
                                    <input class="form-control"
                                           type="password" name="old_pwd" id="old_pwd"/>
                                    @if ($errors->has('old_pwd'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_pwd') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('new_pwd') ? 'has-error' : '' }}">
                                    <label for="new_pwd">Nouveau mot de passe: </label>
                                    <input class="form-control"
                                           type="password" name="new_pwd" id="new_pwd"/>
                                    @if ($errors->has('new_pwd'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_pwd') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="new_pwd_confirmation">Confirmez le mot de passe: </label>
                                    <input class="form-control" type="password" id="new_pwd_confirmation"
                                           name="new_pwd_confirmation"/>
                                </div>
                                <input class="btn btn-secondary pull-right" type="submit" value="Confirmer"/>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-xs-12">
                        <form method="post" action="{{url('/update/user/email')}}">
                            {{csrf_field()}}
                            <fieldset>
                                <legend>Changer votre email</legend>
                                @if (session('confirmation-success-email'))
                                    <div class="alert alert-success">
                                        {{ session('confirmation-success-email') }}
                                    </div>
                                @endif
                                <div class="form-group {{ $errors->has('old_email') ? 'has-error' : '' }}">
                                    <label for="old_email">Email actuel:</label>
                                    <input class="form-control" type="text" id="old_email" name="old_email"/>
                                    @if ($errors->has('old_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('new_email') ? 'has-error' : '' }}">
                                    <label for="new_email">Nouvel email:</label>
                                    <input class="form-control" type="text" id="new_email" name="new_email"/>
                                    @if ($errors->has('new_email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('new_email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="new_email_confirmation">Confirmez l'email:</label>
                                    <input class="form-control" type="text" id="new_email_confirmation"
                                           name="new_email_confirmation"/>
                                </div>
                                <input class="btn btn-secondary pull-right" type="submit" value="Confirmer"/>
                            </fieldset>
                        </form>
                    </div>
                </section>

                <section class="row tab-pane fade" id="account-section-3">
                    <div class="col-xs-12">
                        <h2>Mes listes ({{ count($to_return[1]) }})</h2>
                    </div>
                    @if (count($to_return[1]) === 0)
                        <div class="col-xs-12">
                            <h3>Vous n'avez pas encore créé de liste.</h3>
                            <a href="/create/list">Créer une liste</a>
                        </div>
                    @else
                        <div class="col-xs-12">
                            @for ($i = 0; $i < count($to_return[1]); $i++)
                                <div class="row list-resume">
                                    <div class="col-sm-9">
                                        <h4>
                                            <a href="/list/{{ $to_return[1][$i][0]['id'] }}">{{ $to_return[1][$i][0]['listName'] }}</a>
                                        </h4>
                                        <div class="hidden-xs list-figures">
                                            @foreach ($to_return[1][$i][1][0] as $product)

                                            @if(isset($product[0]->Products[0]))
                                                    <figure>
                                                        <img src="{{ $product[0]->Products[0]->MainImageUrl }}"
                                                             alt="produit"/>
                                                        <figcaption>
                                                            {{ $product[0]->Products[0]->Name }}
                                                        </figcaption>
                                                    </figure>
                                                @else
                                                    <figure>
                                                        <img src="/images/dead.png"
                                                             alt="produit"/>
                                                        <figcaption>
                                                            Produit indisponible !
                                                        </figcaption>
                                                    </figure>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <a href="/delete/userlist/{{ $to_return[1][$i][0]['id'] }}"
                                           class="btn btn-danger" title="Supprimer">Supprimer</a>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
    </div>
@endSection
