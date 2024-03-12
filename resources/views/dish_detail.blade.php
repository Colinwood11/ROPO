@include('include.header')

<body>
    @include('include.navbar')
    @include('include.sidebar')

    <br class="uk-hidden@m">
    <br class="uk-hidden@m">
    <br>
    <div class="uk-section">
        <div class="uk-container uk-container-small">
            <ul class="uk-breadcrumb">
                <li><a href="{{url('/')}}">Home</a></li>
                <li><a href="{{route('order')}}">Order</a></li>
                <li class="uk-disabled"><a>{{$dish['name']}}</a></li>
            </ul>
            <hr class="uk-divider-small">
            <div class="uk-child-width-expand@s uk-grid" uk-grid="">
                <div>
                    <img class="uk-align-center uk-align-left@s uk-margin-remove-adjacent" src="{{asset("").$dish['img']}}" alt="Example image">
                </div>
                <div>
                    <h1 class="uk-article-title">{{$dish['name']}}</h1>

                    @foreach($dish['type'] as $type)
                    <span class="uk-label">{{$type['name']}}</span>
                    @endforeach

                    <p id='price'></p>
                    <p id='NoTableMessage' style="display:none;">Tavolo non identificato, si prega di inserire il code del tavolo dallo staff prima di continuare l'acquisto</p>
                    <form class="uk-fieldset" id = 'purchase_form'>
                        <div class="uk-margin">
                            <div class="uk-panel uk-column-1-1 uk-column-1-2@m" >
                                <label class="uk-form-label" for="form-s-select">Menu</label>
                                <select class="uk-select" id="form-s-select" name="menu" onChange="DispayPrice();">
                                </select>
                            </div>
                            <!-- <span class="uk-form-label">Scelta</span>
                            <div class="uk-form-controls uk-form-controls-text">
                                @foreach($dish['variant'] as $variant)
                                <label><input class="uk-checkbox" type="checkbox"> {{$variant['dish_variant_name']}}</label><br>
                                @endforeach
                            </div> -->
                        </div>
                        <hr class="uk-divider-small">
                        <div class="uk-panel uk-column-1-1 uk-column-1-2@m">
                            <div class="uk-column-1-1">
                                <a class="uk-button uk-button-primary" onclick="Additem({{$dish['id']}} ,'', '{{$dish['name']}}')">@lang('messages.Add')</a>
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>
            <div class="uk-panel uk-column-1-1 uk-column-1-2@m">
                <div class="uk-column-1-1">
                    <!-- <p>Reserved1</p> -->
                </div>
                <div class="uk-column-1-1">
                    <!-- <p>Reserved2</p> -->
                </div>
            </div>
            <hr class="uk-divider-icon uk-margin-medium">
            <!--@lang('messages.description')-->
            <h3>Description</h3>
            <p>{{$dish['description']}}</p>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    var appjson = '@json($dish["dish_menu"])';
    var dish_menu = JSON.parse(appjson);

    window.addEventListener("load", function() {
        
        if (getCookie("code") == "") {
            console.log("no code")
            $('#purchase_form').hide();
            $('#price').hide();
            $('#NoTableMessage').show();
            dish_menu.forEach(function(element, index) {
                if (index == 0) {
                    jQuery("#form-s-select").append("<option value='" + element.menu_id + "'>" + element.name + "</option>"); //为Select追加一个Option(下拉项)
                }
            })
            $("#form-s-select").val(dish_menu[0].menu_id);
        } else {

            console.log("have code")
            dish_menu.forEach(function(element) {
                jQuery("#form-s-select").append("<option value='" + element.menu_id + "'>" + element.name + "</option>"); //为Select追加一个Option(下拉项)
            })

            if (getCookie("menu") != "") {
                $(".uk-select").val(getCookie("menu"));
            } else {
                $("#form-s-select").val(dish_menu[0].menu_id);
            }
        }
        DispayPrice();
    });

    function DispayPrice() {
        var nSel = document.getElementById("form-s-select");
        var checkIndex = $("#form-s-select").get(0).selectedIndex; //获取Select选择的索引值
        var value = nSel.options[checkIndex].value;
        if (!("discounted_price" in dish_menu[checkIndex])) {
            console.log("has no discount");
            document.getElementById("price").innerHTML = dish_menu[checkIndex].price + " €";
        } else {
            console.log("has discount");
            document.getElementById("price").innerHTML = "<em><del>" + dish_menu[checkIndex].price + " €</del> </em><br>" + dish_menu[checkIndex].discounted_price + " €";
        }

        setCookie("menu", value, 1)
    }
</script>

@include('include.footer')

</html>