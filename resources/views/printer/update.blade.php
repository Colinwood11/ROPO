<head>
    <meta charset="gbk">
    <style>
        @page {
            margin-left: 3mm;
            margin-right: 3mm;
            size: 72.1mm 300mm;
        }

        .alphanumeric {
            font-family: Helvetica;
            font-size: 19px;
            line-height: 21px;
        }

        .alphanumeric_CHN {
            font-family: "HanSans",Georgia;
            font-size: 20px;
            line-height: 5px;
        }

        .alphanumeric_right {
            font-family: Georgia, serif;
            font-size: 18px;
            line-height: 21px;
            margin-left: 10px;
        }

        body {
            line-height: 17px;
        }
    </style>
</head>

<body>
    <!-- style="text-align:left;" -->
    <h1 align="center" style="font-family:Helvetica;color:#FFFFFF; background-color:#000000;line-height: 30px; margin-top:-20px">Modifica</h1>
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

    @foreach($print_order['update'] as $update)

    @if(isset($update['dish_name']))
    <div class='alphanumeric'>
        {{$update['dish_name']}}: {{$update['original_number']}}
        @if(isset($update['dish_name_chn']))
        <span class='alphanumeric_CHN'>{{$update['dish_name_chn']}}</span>
        @endif
    </div>
    @endif
    @foreach($update['content'] as $content)

    @switch($content->attribute)
    @case('dish')
    @switch($content['type'])
    @case(1)
    <div class='alphanumeric_right'>
        {!!$content['target_value']!!}
    </div>
    @break
    @case(-1)
    <div class='alphanumeric_right'>
        {{$content['original_value']}}
        @if(isset($content['original_value_chn']))
        <span class='alphanumeric_CHN'>{{$content['original_value_chn']}}</span>
        @endif
        => cancellato
    </div>
    @break
    @case(0)
    <div class='alphanumeric_right'>
        {{$content['original_value']}}
        @if(isset($content['original_value_chn']))
        <span class='alphanumeric_CHN'>{{$content['original_value_chn']}}</span>
        @endif
        =>
        {{$content['target_value']}}
        @if(isset($content['target_value_chn']))
        <span class='alphanumeric_CHN'>{{$content['original_value_chn']}}</span>
        @endif
    </div>
    @break
    @endswitch

    @break
    @case('number')
    <div class='alphanumeric_right'>
        @php
            if($content['target_value'] > $content['original_value']){
                $sign = '+';
            }else{
                $sign = '';
            }
        @endphp
        Quantita': {{$sign}}{{$content['target_value'] - $content['original_value']}}&nbsp;&nbsp; = &nbsp;&nbsp;{{$content['target_value']}}
    </div>
    @break
    @case('menu')
    <div class='alphanumeric_right'>
       {{$content['original_value']}} => {{$content['target_value']}}
    </div>
    @break

    @case('table')
    <div class='alphanumeric_right'>
        tavolo': {{$content['original_value']}} => {{$content['target_value']}}
    </div>
    @break
    @default
    <div class='alphanumeric_right'>
        @lang('messages.'.$type):{{$print_order['old'][$type]}} => {{$value}}
    </div>
    @endswitch
    @endforeach
    <br>
    @endforeach
    <br>
</body>