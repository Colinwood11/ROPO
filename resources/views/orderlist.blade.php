@include('include.header')

<body>
    @include('include.navbar')
    @include('include.sidebar')
    <br class="uk-hidden@m">
    <br class="uk-hidden@m">
    <br>
    <div class="uk-section uk-visible@m">
        <div class="uk-container uk-container-small">
            <h3 class="uk-heading-small uk-text-center">
                <font style="vertical-align: inherit;">@lang('messages.OrderList')</font>
            </h3>
            <p class="uk-text-lead uk-text-center">@lang('messages.orderlist_text')</p>
        </div>
    </div>
    <div class="uk-section">
        <div class="uk-container uk-container-small">
            <ul class="uk-breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="uk-disabled">@lang('messages.OrderList')</a></li>
            </ul>
            <hr class="uk-divider-small">
            <div class="uk-child-width-expand@s" id="list">
                @if($nullorders == 1) 
                <script>
                    window.location.replace("{{url('order')}}");
                </script>
                @else
                <ul class="uk-list uk-list-striped">
                    @foreach($dishs as $dish)
                    <li id='liid_{{$loop->iteration}}'>
                        <div class="uk-child-width-expand@s uk-grid" uk-grid>
                            <div class='uk-width-2-3 uk-first-column'>
                                <span class="uk-badge">{{$dish['menu']}}</span> &nbsp; {{$dish['name']}}
                            </div>
                            <div class="uk-width-1-3 uk-text-right">
                                <div id="numberid_{{$loop->iteration}}">{{$dish['number'] - $dish['que_number']}}</div>
                            </div>
                        </div>
                        <div class="uk-child-width-expand@s uk-grid" uk-grid>
                            <div class="uk-width-1-2 uk-text-right">
                                <a onclick="Checkitem({{$dish['order_id']}},'{{$loop->iteration}}')"><span class=" uk-icon" uk-icon="icon: check" style="color:#1e87f0"></span>1</a>
                            </div>
                            <div class="uk-width-1-2 uk-text-center">
                                <a onclick="Checkallitem({{$dish['order_id']}},'{{$loop->iteration}}')"><span class="uk-icon" uk-icon="icon: check" style="color:#1e87f0"></span>All</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                <div>
                    <div>Sezione dell'attesa del sistema</div>
                    <div>Se l'ordine rimane in questa sezione oltre a 10minuti chiedere l'assistenza</div>
                    <ul class="uk-list uk-list-striped">

                        @foreach($orderque as $dish)
                        <li id='liid_{{$loop->iteration}}'>
                            <div class="uk-child-width-expand@s uk-grid" uk-grid>
                                <div class='uk-width-2-3 uk-first-column'>
                                    <span class="uk-badge">{{$dish['menu']}}</span> &nbsp; {{$dish['name']}}
                                </div>
                                <div class="uk-width-1-3 uk-text-right">
                                    <div id="numberid_{{$loop->iteration}}">{{$dish['number']}}</div>
                                </div>
                            </div>
                            <div class="uk-child-width-expand@s uk-grid" uk-grid>
                                <div class="uk-text-left">

                                </div>
                            </div>
                        </li>
                        @endforeach

                    </ul>
                </div>
                @endif

            </div>
            <hr class="uk-divider-icon uk-margin-medium">
        </div>
    </div>
</body>
<script>
    function myrefresh() {
        window.location.reload();
    }
    window.addEventListener("load", function() {

        setTimeout('myrefresh()', 20000);
    });

    function Checkitem(oid, number) {
        $.ajax({
            url: 'api/ordering/confirm',
            type: "POST",
            data: {
                "id": oid,
                "que_number": 1,
                "code": getCookie('code')
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                console.log(data);
                document.getElementById("numberid_" + number).innerHTML = document.getElementById("numberid_" + number).innerHTML - 1;
                UIkit.modal.alert('OK').then(function() {
                    console.log('Alert closed.')
                    window.location.reload();
                });
            },
            error: function(data) {
                UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            },
            timeout: 10000
        });
    }

    function Checkallitem(oid, number) {
        $.ajax({
            url: "{{Route('OrderConfirmGuest')}}",
            type: "POST",
            data: {
                "id": oid,
                "que_number": document.getElementById("numberid_" + number).innerHTML,
                "code": getCookie('code')
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                UIkit.modal.alert('OK').then(function() {
                    console.log('Alert closed.')
                    window.location.reload();
                });
            },
            error: function(data) {
                UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            },
            timeout: 10000
        });
    }
</script>
@include('include.footer')

</html>