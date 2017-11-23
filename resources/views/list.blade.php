@extends('template.main')

@section('title', 'Nom de liste')

@section('mid-content')
    <!--
    //////////////////////////////////////////////////////////////////////
    ///
    ///
    ///     Acceder à la note -> $listjson['Rates'][indice]['rating']
    ///
    ///     Acceder à l'utilisateur ayant posté la note -> $listjson['Rates'][indice]['User'][laProprietéVoulueDeLaTableUser]
    ///
    ///     Pour les commentaires c'est la meme chose mais avec Comments à la place de Rates
    ///
    //////////////////////////////////////////////////////////////////////
    /registercomment &idList &remark
    /registerrate &idList &rating
-->
    <div class="list-detail">
        <div class="list-header row">
            <div class="col-xs-12">
                <div class="list-rating">
                    @guest
                    <div class="rateyo" title="Note moyenne : {{ $listjson['Avg'] }}" data-rateyo-rating="{{ $listjson['Avg'] }}" data-rateyo-read-only="true"></div>
                    @else
                    <div class="rateyo" title="Note moyenne : {{ $listjson['Avg'] }}" data-rateyo-rating="{{ $listjson['Avg'] }}" data-list-id="{{ $listjson['list']['id'] }}"></div>
                    @endguest
                    <span>Pour {{ count($listjson['Rates']) }} notes</span>
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
                <button data-listId="{{ $listjson['list']['id'] }}" class="btn btn-default">Ajouter au panier</button>
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
    <div class="comments-master row">
        <div class="comments-header">
            <h2>Commentaires</h2>
        </div>
        @guest
        <h4>Connectez-vous pour commenter.</h4>
        @else
        <form class="comments-form" method="post" action="/">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Titre"/>
            </div>
            <div class="form-group">
                <textarea class="form-control" placeholder="Commentaire"></textarea>
            </div>
            <button type="submit" class="btn btn-default pull-right">Envoyer</button>
        </form>
        @endguest
        <div class="comments">
            <?php var_dump($listjson['Comments']); ?>
            <div class="comment col-md-10 col-md-offset-1">
                <h3>adieu</h3>
                <h5>Par amélie le 30/02/2017</h5>
                <p>
                    déçue, je ne reviendrai pas ici.
                </p>
            </div>
            <div class="comment col-md-10 col-md-offset-1">
                <h3>un délice</h3>
                <h5>Par charlie le 10/12/2017</h5>
                <p>
                    ai passé de très bons moments grâce à "list'in". recommande chaudement!!
                </p>
            </div>
        </div>
    </div>
@endsection
