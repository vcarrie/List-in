@extends('template.main')

@section('title', 'Nom de liste')

@section('mid-content')
    <div class="list-detail">
        <div class="list-header">
            <h1>{{ $listjson['Name'] }}
                <div>{{ $listjson['TotalPrice'] }} €</div>
            </h1>
            <h5>par {{ $listjson['Creator'][0]['pseudo'] }}
                <button class="btn btn-default">Ajouter au panier</button>
            </h5>
            <h6>
                @foreach ($listjson['Tags'] as $tag)
                    <span class="label label-default">{{ $tag['tagName'] }}</span>
                @endforeach
            </h6>
            <p>
                {{ $listjson['Description'] }}
            </p>
        </div>
        <section class="cards-container">
            @foreach ($listjson['Items'] as $item)
                <div class="card">
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