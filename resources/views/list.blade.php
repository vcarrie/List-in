@extends('template.main')

@section('title', $listjson['list']->listName)

@section('mid-content')
    <div class="list-detail">
        <div class="list-header row">
            <div class="col-xs-12">
                <div class="list-rating">
                    <?php
                    if (is_null($listjson['userRating'])) {
                        $ratingdesc = "Pour ".count($listjson['Rates'])." notes";
                        $listrating = $listjson['Avg'];
                    } else {
                        $ratingdesc = "Vous avez noté cette liste le ".substr($listjson['userRating']->updated_at,0,10);
                        $listrating = $listjson['userRating']->rating;
                    }
                    ?>
                    @guest
                    <div class="rateyo" title="Note moyenne : {{ $listjson['Avg'] }}" data-rateyo-rating="{{ $listjson['Avg'] }}" data-rateyo-read-only="true"></div>
                    @else
                    <div class="rateyo" title="Note moyenne : {{ $listjson['Avg'] }}" data-rateyo-rating="{{ $listrating }}" data-list-id="{{ $listjson['list']['id'] }}"></div>
                    @endguest
                    <span>{{ $ratingdesc }}</span>
                </div>
            </div>
            <div class="col-xs-8">
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
            <div class="list-options col-xs-4">
                <h1>
                    {{ $listjson['TotalPrice'] }} €
                </h1>
                @if ($listjson['listIsInCart'] === false)
                <button data-listId="{{ $listjson['list']['id'] }}" class="btn btn-default">Ajouter au panier</button>
                @else
                <button data-listId="{{ $listjson['list']['id'] }}" class="btn btn-default btn-activated">Liste ajoutée</button>
                @endif
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
                            <img alt="{{ $item['Name'] }}" src="{{ $item['Image'] }}"/>
                        </div>
                        <div class="card-body">
                            <h4 title="{{ $item['Name'] }}">{{ $item['Name'] }}</h4>
                            <p>{{ $item['Description'] }}</p>
                        </div>
                        <div class="card-footer">
                            <div class="card-quantity-list">Quantité : {{ $item['Quantity'] }}</div>
                            <div class="card-price-list card-price">{{ $item['Price'] }} €</div>
                        </div>

                </div>
            @endforeach
        </section>
    </div>
    <div class="comments-master row">
        <div class="comments-header">
            <h2>Commentaires</h2>
        </div>
        @guest
        <h4>Connectez-vous pour commenter.</h4>
        @else
        <form class="comments-form" method="post" action="/list/{{ $listjson['list']['id'] }}">
            <div class="form-group">
                <textarea name="remark" class="form-control" placeholder="Commentaire"></textarea>
            </div>
            <input type="hidden" name="username" value="{{ Auth::user()->pseudo }}" />
            <input type="hidden" name="listid" value="{{ $listjson['list']['id'] }}" />
            <button type="submit" class="btn btn-default pull-right">Envoyer</button>
        </form>
        @endguest
        <div class="comments">
            @foreach ($listjson['Comments'] as $comment)
            <div class="comment col-md-10 col-md-offset-1">
                <h5>Par <span>{{ $comment['User']['pseudo'] }}</span> le {{ str_replace(' ', ' à ', $comment['created_at']) }}</h5>
                <p>
                    {{ $comment['remark'] }}
                </p>
            </div>
            @endforeach
        </div>
    </div>
@endsection
