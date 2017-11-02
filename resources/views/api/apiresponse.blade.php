@if($result["ErrorMessage"] == NULL)
    @if($result['Products'] != NULL)
        <table style='border: 2px black solid; margin:auto;' width='75%'>

            @foreach($result["Products"] as $product)

                <tr>
                    <td width='33%' style='text-align: center;'>
                        <img src="{{$product["MainImageUrl"]}}" alt="{{$product["Name"]}}">
                    </td>
                    <td width='33%' style='text-align: center;'>
                        {{$product["Name"]}}<br><br>
                        {{$product["Rating"]}} / 5<br><br>
                        {{$product["Description"]}}<br><br>

                    </td>
                    <td width='33%' style='text-align: center;'>
                        {{number_format($product["BestOffer"]["SalePrice"], 2, ',', '')}} €<br>

                        @if($product["BestOffer"]["IsAvailable"] == true)
                            Disponible!
                        @else
                            Non disponible !
                        @endif
                        <br>
                    </td>
                </tr>
            @endforeach

        </table>

    @else
        Pas de résultat !
    @endif

@else
    Erreur
@endif