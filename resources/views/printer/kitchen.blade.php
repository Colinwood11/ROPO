<head>
    <meta charset="gbk">
    <style>
        @page {
            margin-left: 3mm;
            margin-right: 3mm;
            size: 72.1mm 300mm;
        }

        @font-face {
            font-family: "HanSans";
            src: url({{storage_path('fonts\SourceHanSansCN-Normal.ttf')}}) format("truetype");
        }

        .alphanumeric {
            font-family: Georgia, serif;
            font-size: 20px;
            line-height: 21px;
        }

        .alphanumeric_CHN {
            font-family: "HanSans",Georgia;
            font-size: 20px;
            line-height: 5px;
        }

        .alphanumeric_left {
            font-family: Helvetica;
            font-size: 14px;
            width: 40mm;
        }

        body {
            line-height: 17px;
        }
    </style>
</head>

<body>
    <!-- <h1 align="center" style="color:#FFFFFF; background-color:#000000;line-height: 35px;">Modifica</h1> -->
    <div style="text-align: left;">
        {{$print_order['created_at']}}
        <span style="float:right;font-size: 1.5em; font-weight: bolder;">
            @isset($print_order['table_number'])
            @lang('messages.Table'):{{$print_order['table_number']}}
            @endisset
        </span>

    </div>

    <br>
    <div class='alphanumeric'>
        @isset($print_order['note'])
        @lang('messages.Address') : {{$print_order['note']}}
        @endisset
    </div>
    <div>
        @foreach($print_order['menus'] as $menu)
        <div class='alphanumeric'>
            {{$menu['menu_name']}} :
        </div>
        <div>
            @foreach($menu['dishes'] as $dish)
                @if(isset($dish['name_chn']))
                    <p class='alphanumeric' style="margin-top:5px;margin-bottom:5px;">{{$dish['number']}}  {{$dish['name']}}
                        <span class='alphanumeric_CHN'>{{$dish['name_chn']}}</span>
                    </p>
                @else
                    <p class='alphanumeric' style="margin-top:3px;margin-bottom:3px;">
                        {{$dish['number']}} {{$dish['name']}}
                    </p>
                @endif
                @if(isset($dish['note']))
                <p class='alphanumeric' style="margin-top:3px;margin-bottom:3px;">
                    {{$dish['note']}}
                </p>
                @endif
            @endforeach
        </div>
        <br>
        @endforeach
    </div>
    <br>
    <div class='alphanumeric'>
        <p><span style="float:right;">
                @isset($print_order['table_number'])
                Persona:{{$print_order['num_person']}}
                @endisset
            </span>
            Total: {{$print_order['total']}}
        </p>
    </div>
</body>