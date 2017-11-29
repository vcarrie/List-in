@extends('template.master')

@section('title', 'Admin gestion')

@section('main')

    <div id="admin_panel" class="panel panel-default col-md-4 col-md-offset-4">
        <div class="panel-heading"><strong>Gestion administrateur</strong></div>
        <div class="col-md-6 col-md-offset-3">
          <input type="button" class="btn btn-secondary" value="Gérer les tags" OnClick="window.location.href='/manage/tag'" /></br></br>


          <div id="list_deletion">
            Liste à supprimer :</br>
            <select id="id_list_to_delete">
                @foreach($tab_final[0] as $id)
                    <option id="{{ $id }}" value="{{ $id }}">{{ $id }}</option>
                @endforeach
            </select>
            <input type="button" id="suppr_list" class="btn btn-secondary" value="Supprimer"></br>
          </div></br>


          <div id="user_deletion">
            Utilisateur à supprimer :</br>
            <select id="id_user_to_delete">
                @foreach($tab_final[1] as $id)
                    <option id="{{ $id }}" value="{{ $id }}">{{ $id }}</option>
                @endforeach
            </select>
            <input type="button" id="suppr_user" class="btn btn-secondary" value="Supprimer"></br>
          </div>


          <br>
        </div>
    </div>



@endsection
