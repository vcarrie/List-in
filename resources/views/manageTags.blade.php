@extends('template.master')

@section('title', 'Gérer les tags')

@section('main')
    <br>
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6">
            <div class="row">
                <div class="col-3 col-sm-3 col-md-2"></div>
                <div class="col-6 col-sm-6 col-md-8 text-center pagination-centered">
                    <form action="{{url('/create/tag')}}" method="post">
                        {{csrf_field()}}
                        <label for="newTag"></label>
                        <input name="newTag" id="newTag" class="form-control form-control-sm" type="text">
                        <input type="submit" class="btn btn-secondary" value="Ajouter">
                    </form>
                </div>
                <div class="col-3 col-sm-3 col-md-2"></div>
            </div>
        </div>

        <div class="col-md-1"></div>
        <div class="col-12 col-sm-12 col-md-5" style="margin: 0 10px;">
            <form action="{{url('/delete/tag')}}" method="post">
                {{csrf_field()}}
                <input type="submit" class="btn btn-secondary" value="Supprimer">
                <table class="table table-responsive">
                    @foreach($tags as $tag)

                        <tr class="raw">
                            <td class="col-md-11 col-sm-11" style="vertical-align: middle">{{$tag->tagName}}</td>
                            <td class="col-md-1 col-sm-1">
                                <label><input style="vertical-align: middle" value="{{$tag->id}}" name="tags[]"
                                              type="checkbox"></label>
                            </td>
                        </tr>

                    @endforeach
                </table>
            </form>
        </div>
    </div>
@endsection