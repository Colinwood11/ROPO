<head>
    <style>
        @page {
            margin-left: 5mm;
            margin-right: 5mm;
            size: 72.1mm 297mm;
        }

        .alphanumeric {
            font-family: Helvetica;
            font-size: 14px;
        }

        .alphanumeric_left {
            font-family: Helvetica;
            font-size: 14px;
            width: 50mm;
        }

        .alphanumeric_global {
            font-size: 15px;
            line-height: 12px;
        }

        .list_print {
            margin-left: 0px;
            margin-right: 0px;
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
    <div class='alphanumeric_global' style="text-align:center">
        <p style="white-space: pre-line;">
            {{$settings['checkout_header']['value']}}
        </p>

    </div>
    <br>
    <div>
        @isset($print_order['table_number'])@lang('messages.Table'):{{$print_order['table_number']}}@endisset
        <br>
        Numero Progressivo:{{$print_order['id']}}
        <br>
        Data:{{$print_order['created_at']}}
    </div>
    <div class='alphanumeric' style="text-align:left;">
        <div class='alphanumeric_left'>

        </div>
    </div>
    <br>
    @isset($print_order['note'])
    <div class='alphanumeric'>
        @lang('messages.Address') : {{$print_order['note']}}
    </div>
    @endisset

    <div>
        @foreach($print_order['menus'] as $menu)
        <div class='alphanumeric'>
            <div>
                <div class='alphanumeric_left'>
                    {{$print_order['persons']}} x {{$menu['name']}} :
                    @if($menu['fixed_price'] != 0)
                    {{number_format($menu['fixed_price'],2,',')}}€
                    @endif
                </div>

            </div>
            @foreach($menu['dishes'] as $dish)
            <div class='alphanumeric list_print'>

                <div class='alphanumeric_left' style='float: left;text-align:left;'>
                    {{$dish['number']}} x {{$dish['dish']}}
                </div>
                @if($dish['price'] != 0)
                <span style="float:right;text-align: right;">
                    {{number_format($dish['price'],2,',')}}€
                </span>
                @endif

            </div>
            <div style="clear: both;"></div>
            @endforeach
        </div>
        <br>
        @endforeach
    </div>

    <div class='alphanumeric' style='float: left;text-align:left;'>
        @lang('messages.total'):
    </div>
    <span style="float:right;text-align: right;">
        {{number_format($print_order['total_price'],2,',')}}€
    </span>

</body>