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
                <font style="vertical-align: inherit;">
                    <font style="vertical-align: inherit;">@lang('messages.Cart')</font>
                </font>
            </h3>
            <p class="uk-text-lead uk-text-center">@lang('messages.cart_text')</p>
        </div>
    </div>
    <div class="uk-section">
        <div class="uk-container uk-container-small">
            <ul class="uk-breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li class="uk-disabled">@lang('messages.Cart')</a></li>
            </ul>
            <hr class="uk-divider-small">
            <div class="uk-child-width-expand@s uk-grid" uk-grid id="list">
                @if($nullcart == 1)
                <p class="uk-text-lead uk-text-center"> @lang('messages.cart_null_text')</p>
                @else
                <ul class="uk-list uk-list-striped">
                    @foreach($dishs as $dish)
                    <li id='liid_{{$dish['key']}}'>
                        <div class="uk-child-width-expand@s uk-grid" uk-grid>
                            <div class='uk-width-2-3 uk-first-column'>
                                <span class="uk-badge">{{$dish['menu']}}</span> &nbsp; {{$dish['name']}}
                            </div>
                            <div class="uk-width-1-3 uk-text-right">
                                <div id="cart_number_{{$dish['key']}}">{{$dish['number']}}</div> x {{$dish['price']}} €
                            </div>
                        </div>
                        <div class="uk-child-width-expand@s uk-grid" uk-grid>
                            <div class="uk-width-1-3 uk-text-right">
                                <a class=" uk-icon" uk-icon="icon: plus-circle" style="color:#1e87f0" onclick="Additem({{$dish['dish_id']}} ,{{$dish['menu_id']}}, '{{$dish['name']}}','2',{{$dish['key']}})"></a>
                            </div>
                            <div class="uk-width-1-3 uk-text-center">
                                <a class="uk-icon" uk-icon="icon: minus-circle" style="color:#1e87f0" onclick="Delitem({{$dish['dish_id']}} ,{{$dish['menu_id']}}, '{{$dish['name']}}',{{$dish['key']}})"></a>
                            </div>

                            <div class="uk-width-1-3 uk-text-left">
                                <a class=" uk-icon" uk-icon="icon: trash" style="color:#f0506e" onclick="Delallitem({{$dish['dish_id']}} ,{{$dish['menu_id']}}, '{{$dish['name']}}',{{$dish['key']}})"></a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <hr class="uk-divider-icon uk-margin-medium">
            <div class="uk-panel uk-column-1-2">
                <div class="uk-column-1-1">
                    <a class="uk-button uk-button-primary" onclick="doreset()">@lang('messages.Reset')</a>
                </div>
                <div class="uk-column-1-1">
                    <a class="uk-button uk-button-primary" onclick="dopost()">@lang('messages.Confirm')</a>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    var OrderLock = 0;

    function dopost() {

        if (OrderLock == 0) {
            OrderLock = 1
            cart = {}
            if(getCookie('cart') != "")
            {
                cart = JSON.parse(getCookie('cart'));
                delete cart['row_number'];
            }

            if (_.isEmpty(cart) == false) {
                cart = Object.values(cart);
                $.ajax({
                    url: 'api/ordering/insert_guest',
                    type: "POST",
                    data: {
                        "cart": cart,
                        "code": getCookie('code')
                    },
                    dataType: "JSON",
                    sync: 'true',
                    success: function(data) {
                        console.log(data);
                        setCookie('cart', "", 1);
                        UIkit.modal.alert('Ora vai alla lista del\'ordine!').then(function() {
                            console.log('Alert closed.')
                            window.location.replace("{{url('orderlist')}}");
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
            } else {
                UIkit.modal.alert('Non hai scelto piati ancora, vai a ordinare！').then(function() {
                    console.log('Alert closed.')
                    window.location.replace("{{url('order')}}");
                });
            }
        }

    }

    function doreset() {
        setCookie('cart', "", 1);
        UIkit.notification({
            message: '<span uk-icon=\'icon: trash\'></span> Dell all success',
            status: 'danger',
            pos: 'bottom-center'
        });
        document.getElementById("list").innerHTML = '<p class="uk-text-lead uk-text-center"> @lang("messages.cart_null_text")</p>';
    }
</script>
@include('include.footer')

</html>