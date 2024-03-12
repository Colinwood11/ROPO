@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">
            <h3>Tavolo：{{$orders['number']}}
            </h3>
            Numero Progressivo:{{$orders['id']}}
            <br>
            Totale: {{$orders['total_price']}} €
            <br>
            DATA:{{$orders['created_at']}}
            <br>
            @if(isset($orders['table_number']))
            @lang('messages.Table'): {{$orders['table_number']}}
            @else
            Asporto/Senza Tavolo
            @endif
            <br>
        </div>
    </div>
</div>
<hr>
<div class="uk-card uk-card-default">
    <ul class="uk-list uk-list-striped">
        @foreach($orders['menus'] as $menu)
        <li>
            <div>
                {{$orders['persons']}} x {{$menu['name']}} :
                @if($menu['fixed_price'] != 0)
                <span style="float:right;">
                    {{number_format($menu['fixed_price'],2,',')}}€
                </span>
                @endif
            </div>
            <div style="clear: both;"></div>   
            <ul class="uk-list" style="padding-left: 10px">
                @foreach($menu['dishes'] as $dish)
                <li>
                        {{$dish['number']}} x {{$dish['dish']}}
                        @if($dish['price'] != 0)
                        <span style="float:right;">
                            {{number_format($dish['price'],2,',')}}€
                        </span>
                        @endif
                    <div style="clear: both;"></div>                  
                </li>
                @endforeach
            </ul>
        </li>
        <br>
        @endforeach
    </ul>
</div>
@stop