@extends('template.master')

@section('title', 'Register')

@section('main')
    <div class="container">
        <div class="row " style="margin-top: 3%">
            <div class="col-md-12">
                <!-- PARTIE INSCRIPTION -->
                <div class="col-md-5 col-md-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Inscrivez-vous pour profiter de tout notre site !</strong></div>
                        @if (session('confirmation-success'))
                            <div class="alert alert-success">
                                {{ session('confirmation-success') }}
                            </div>
                        @endif
                        <div class="panel-body">
                            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('pseudo') ? ' has-error' : '' }}">
                                    <label for="pseudo" class="col-md-4 control-label">Pseudonyme</label>

                                    <div class="col-md-6">
                                        <input id="pseudo" type="text" class="form-control" name="pseudo"
                                               value="{{ old('pseudo') }}" required>

                                        @if ($errors->has('pseudo'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('pseudo') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('firstName') ? ' has-error' : '' }}">
                                    <label for="firstName" class="col-md-4 control-label">Prénom</label>

                                    <div class="col-md-6">
                                        <input id="firstName" type="text" class="form-control" name="firstName"
                                               value="{{ old('firstName') }}" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('firstName') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('lastName') ? ' has-error' : '' }}">
                                    <label for="lastName" class="col-md-4 control-label">Nom</label>

                                    <div class="col-md-6">
                                        <input id="lastName" type="text" class="form-control" name="lastName"
                                               value="{{ old('lastName') }}" required>

                                        @if ($errors->has('lastName'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('lastName') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">E-mail</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">Mot de passe</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                          <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">Confirmer le mot de
                                        passe</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required>
                                    </div>
                                </div>

                                <div class="form-group {{ $errors->has('cgu') ? ' has-error' : '' }}">
                                    <div class="col-md-offset-3">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="cgu" {{ old('cgu') ? 'checked' : '' }}>
                                                J'accepte les <a href="/cgu">conditions d'utilisation</a>
                                            </label>
                                            @if ($errors->has('cgu'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('cgu') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="col-md-offset-2">
                                        <div class="checkbox">
                                            {!! Recaptcha::render() !!}
                                            @if ($errors->has('g-recaptcha-response'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button class="btn btn-secondary">
                                            S'enregistrer
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- PARTIE CONNEXION -->
                <div class="col-md-5">
                    <div class="panel panel-default">
                        <div class="panel-heading"><strong>Déjà inscrit? connectez-vous !</strong></div>
                        <div class="panel-body">
                            @if (session('confirmation-danger'))
                                <div class="alert alert-danger">
                                    {!! session('confirmation-danger') !!}
                                </div>
                            @endif
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('emailLogin') ? ' has-error' : '' }}">
                                    <label for="emailLogin" class="col-md-4 control-label">Adresse e-mail</label>

                                    <div class="col-md-6">
                                        <input id="emailLogin" type="email" class="form-control" name="email"
                                               value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('emailLogin'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('emailLogin') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('passwordLogin') ? ' has-error' : '' }}">
                                    <label for="passwordLogin" class="col-md-4 control-label">Mot de passe</label>

                                    <div class="col-md-6">
                                        <input id="passwordLogin" type="password" class="form-control" name="password"
                                               required>

                                        @if ($errors->has('passwordLogin'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('passwordLogin') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <div class="checkbox">
                                            <label style="color:#e03913;">
                                                <input type="checkbox"
                                                       name="remember" {{ old('remember') ? 'checked' : '' }}> Se
                                                souvenir de moi
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group" style="text-align: center">
                                    <div class="col-md-8 col-md-offset-2">
                                        <button type="submit" class="btn btn-secondary">
                                            Se connecter
                                        </button>

                                        <a class="btn btn-link" href="{{ route('password.request') }}">Mot de passe
                                            oublié ?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
