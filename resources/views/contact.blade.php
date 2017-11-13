@extends('template.master')

@section('title')
    Contact
@endsection

@section('main')
    <br>
    <div class="container" style="margin: 2rem; text-align: center; padding-left:4rem; padding-right:4rem; max-width:500px; margin:0px auto;">
        <div class="row card text-white bg-dark">
            <h1 class="card-header" style="font-weight:bold">Contactez-nous</h1>
            <h4 class="card-header">Des idées, des remarques, des questions ?</h4>
            <h4 class="card-header">Faites-nous en part !</h4>
            <div class="card-body">
                <form action="{{ url('contact') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}" name="nom" id="nom" placeholder="Votre nom" value="{{ old('nom') }}">
                        {!! $errors->first('nom', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email" placeholder="Votre email" value="{{ old('email') }}">
                        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="form-group">
                        <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message" placeholder="Votre message" style="height:275px;">{{ old('message') }}</textarea>
                        {!! $errors->first('message', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <button type="submit" class="btn btn-secondary" style="background-color: #e03913; color: #fff">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
