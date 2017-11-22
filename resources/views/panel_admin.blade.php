@extends('template.master')

@section('title', 'Admin gestion')

@section('main')
    <script>


    </script>


    -  <a href="/manage/tag">Gérer les tags</a><br>
    -  <a href="#" id="suppr_list">Supprimer une liste</a>

    <select id="id_list_to_delete">
        @foreach($tab_final[0] as $id)
            <option id="{{ $id }}" value="{{ $id }}">{{ $id }}</option>
        @endforeach
    </select>

    <br>
    -  <a href="#" id="suppr_user">Supprimer un utilisateur</a>

    <select id="id_user_to_delete">
        @foreach($tab_final[1] as $id)
            <option id="{{ $id }}" value="{{ $id }}">{{ $id }}</option>
        @endforeach
    </select>
    <br>


@endsection