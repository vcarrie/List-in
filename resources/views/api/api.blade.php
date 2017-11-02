@extends('layouts.base')
@section('content')
    <form action="" accept-charset="UTF-8" method="POST" id="searchForm">
        {!! csrf_field() !!}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <label for="search" >Votre recherche :</label>
        <input type="text" id="search" name="search" class="form-control {{ $errors->has('search') ? 'is-invalid' : '' }}"
                value="{{ old('search') }}">
        {!! $errors->first('search', '<div class="invalid-feedback">:message</div>') !!}
        <input type="submit" value="Rechercher">
    </form>
    <div id="resultSearch">
        @yield('responses')
    </div>
@endsection