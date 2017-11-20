@extends('template.main')

@section('title', 'Nom de liste')

@section('mid-content')
    <div class="list-detail">
        <div class="list-header row">
            <div class="col-md-8">
                <h1>
                    {{ $listjson['list']['listName'] }}
                </h1>
                <h5>
                    par {{ $listjson['list']['creator']['pseudo'] }}
                </h5>
                <h6>
                    @foreach ($listjson['list']['Tags'] as $tag)
                        <span class="label label-default">{{ $tag['tagName'] }}</span>
                    @endforeach
                </h6>
                <p>
                    {{ $listjson['list']['description'] }}
                </p>
            </div>
            <div class="col-md-4">
                <h1>
                    {{ $listjson['TotalPrice'] }} €
                </h1>
                <button class="btn btn-default">Ajouter au panier</button>
            </div>
        </div>
        <div class="list-images">
            @foreach ($listjson['Items'] as $item)
                <img data-bind="item-{{ $item['Id'] }}" src="{{ $item['Image'] }}" alt="{{ $item['Name'] }}"/>
            @endforeach
        </div>
        <section class="cards-container">
            @foreach ($listjson['Items'] as $item)
                @if ($loop->first)
                <div id="item-{{ $item['Id'] }}" class="card">
                @else
                <div id="item-{{ $item['Id'] }}" class="card hidden">
                @endif
                        <div class="card-snapshots">
                            <img src="{{ $item['Image'] }}"/>
                        </div>
                        <div class="card-body">
                            <h4>{{ $item['Name'] }}</h4>
                            <p>{{ $item['Description'] }}</p>
                        </div>
                        <div class="card-footer">
                            <div class="card-price">{{ $item['Price'] }} €</div>
                        </div>
                </div>
            @endforeach
        </section>
    </div>
@endsection
