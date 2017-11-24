@extends('template.master')

@section('title', 'Contact')

@section('main')
    <br>
    <div class="container-contact">
        <div class="row card text-white bg-dark">
            <h1 class="card-header-contact">Contactez-nous</h1>
            <p class="card-header">Des idées, des remarques, des questions ?</p>
            <p class="card-header">Faites-nous en part !</p>
            <div class="card-body">
                <form action="{{ url('contact') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}" name="nom"
                               id="nom" placeholder="Votre nom" value="{{ old('nom') }}">
                        {!! $errors->first('nom', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               name="email" id="email" placeholder="Votre email" value="{{ old('email') }}">
                        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <textarea class="form-control-contact {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" placeholder="Votre message">{{ old('message') }}</textarea>
                        {!! $errors->first('message', '<div class="invalid-feedback">:message</div>') !!}
                    </div>

                    <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                        <div class="captcha-contact">
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
                    <button type="submit" class="btn btn-secondary">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
