@extends('admin.template')
@section('content')


<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">

            <h3>Order List</h3>
            <table class="uk-table uk-table-striped uk-table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome Piatto </th>
                            <th>Numero Tavolo</th>
                            <th>Menu</th>
                            <th>Ordinato a</th>
                            <th>Stato</th>
                            <th>Prezzo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{$order['id']}}</td>
                            <td>{{$order['dish']['name']}}</td>
                            <td>
                                @if(isset($order['table_history']['table']))
                                    {{$order['table_history']['table']['number']}}
                                @else
                                    Niente Tavolo / Asporto
                                @endif
                            </td>
                            <td>
                                @php
                                $res = array_values(array_filter($menus,function($item) use($order)
                                {
                                    return $item['id'] == $order['menu'];
                                }));
                                if(isset($res[0]))
                                {
                                    echo($res[0]['name']);
                                }
                                else
                                {
                                    echo('Null');
                                }
                                @endphp
                            </td>
                            <td>{{$order['order_at']}}</td>                             
                            <td>{{$order['status']}}</td>
                            <td>
                                {{$order['price']}} €
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>              

        </div>
    </div>
</div>



<hr class="uk-divider-icon uk-margin-medium">
<!--@lang('messages.description')-->
@stop