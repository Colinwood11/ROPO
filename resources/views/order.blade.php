@include('include.header')

<body>
    @include('include.navbar')
    @include('include.sidebar')

    <div class="uk-section">
    </div>

    <div class="uk-section">
        <div class="uk-container uk-container-small">
            <p class="uk-text-lead uk-text-center">
                <b style="color:#FF0000" ;>*l'immagine è solo un riferimento</b>
            </p>
            @foreach ($menu_list as $menu)
            @if($menu->weight == 0)
            @php ($default_active = $menu->id) @endphp
            @endif
            @endforeach

            <!-- <button id="filter" class="uk-button uk-button-primary" type="button" uk-toggle="target: #scrollbar" aria-expanded="true">@lang('messages.Filter')</button> -->
            <div id="scrollbar" class="uk-container">
                @foreach ($cats as $cat)
                <div class="uk-grid-small uk-grid-divider uk-child-width-auto" uk-grid>
                    <h3>{{ $cat["Catname"] }}</h3>
                    <div>
                        <ul class="uk-subnav uk-subnav-pill" uk-margin>
                            <li class="uk-active">
                                <a id="cat{{ $cat['id'] }}-sub0" onclick="changetype({{ $cat['id'] }},)">>All</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="uk-subnav uk-subnav-pill" uk-margin>
                            @foreach ($cat["subcategory"] as $sub)
                            <li>
                                <a id="cat{{ $cat['id'] }}-sub{{ $sub['id'] }}" onclick="changetype({{ $cat['id'] }},{{
                                        $sub['id'] }})">{{ $sub['name'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach
                <hr class="uk-margin-medium-top">
                Ordina per: <a onclick="DishSort('number_code')">Numero</a>,<a onclick="DishSort('name')">Nome</a>
            </div>

            <table class="uk-width-1-1">
                <tbody id='dishs_area'></tbody>
                <!-- <div uk-spinner='ratio: 5'></div> -->
            </table>
        </div>
    </div>

</body>
<script>
    var dishs = '';
    var dishs_indexed = '';
    var page_all = 0;
    var idcache = {};
    var ids = [];
    var page_now = 1;
    var menu_indexed = '';

    window.addEventListener("load", function() {

        @php
        //初始化菜单变量,因为需要购物车的菜单名字
        @endphp
        getAllMenu();

        if (checkAuditTime("14:30", "15:00") || checkAuditTime("23:20", "23:59")) {
            UIkit.modal.alert('Stiamo per chiudere, se vuoi ancora ordinare, ti preghiamo di inviare il cibo che desideri il prima possibile. Grazie per la collaborazione!').then(function() {

            });
        }

        @php
        //初始化载入购物车。
        @endphp
        if (getCookie("cart") != "" && getCookie("cart") != "{}") {
            getAllDish();
            //不可以把剩余的代码写这里因为ajax是一个异步【线程】。
        }

    });

    function InitSetMenu(){
        if (getCookie("code") == "") {
                console.log('cookie not exists');
                Change_menu("2");
            } else {
                console.log('cookie exists');
                Change_menu(getCookie("menu"));
            }
    }

    //因为我们需要所有的菜来获取购物车里的菜名。
    function getAllDish() {
        $.ajax({
            url: "{{Route('ApiDishAll')}}",
            type: "GET",
            timeout: 10000,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                if (data == []) {
                    console.log('dish is empty')
                } else {
                    dishs_indexed = _(data).indexBy('id');
                    //这里才是ajax成功之后的代码。
                    ParseCart();
                }
            },
            error: function(data) {
                UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:<em>' + data.responseText + '</em>').then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            }
        });
    }

    //因为我们需要所有的menu来显示menu的名字。
    function getAllMenu() {
        $.ajax({
            url: "{{Route('ApiAllMenu')}}",
            type: "GET",
            timeout: 10000,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                if (data == []) {
                    console.log('menu is empty')
                } else {
                    menu_indexed = _(data).indexBy('id');
                    InitSetMenu();
                }
            },
            error: function(data) {
                UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:<em>' + data.responseText + '</em>').then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            }
        });
    }


    function ParseCart() {
        cart = JSON.parse(getCookie('cart'));
        delete cart['row_number'];
        cart_array = Object.values(cart);
        cart_array.forEach((element, index) => {

            id = element.dish_id
            key = id.toString() + element.menu.toString();
            var template = `<li id="cart_${key}" style="margin: 30px;">\
                <div style="margin-bottom: 10px;"><span class="uk-badge">${menu_indexed[element.menu].name}</span>&nbsp;${dishs_indexed[id].name}</div>\
                <div class="uk-child-width-1-3" style="text-align: center;" uk-grid>\
                    <a class="uk-icon" uk-icon="minus-circle" onclick="SubItemCart(${id} ,${element.menu},${key})"></a> \
                    <div id="cart_number_${key}">${element['number']}</div> \
                    <a class="uk-icon" uk-icon="plus-circle" onclick="AddItemCart(${id} ,${element.menu},${key})"></a>\
                </div>\
            </li>`;
            $("#cart-area-id").append(template);
        })
    }

    function Change_menu(id,name='') {
        
        console.log(menu_indexed);
        menuName = menu_indexed[id].name;
        console.log('menu exists');
        $('#menu').text(menuName);
        setCookie("menu", id, 1);
        getDishFiltered(id, ids);
    }

    var CatSelectOld = [0, 0, 0, 0]

    function changetype(catid, subid) {

        var oldtypebychange = "#cat" + catid + "-sub" + CatSelectOld[catid - 1];
        console.log(oldtypebychange)
        $(oldtypebychange).parent().removeClass("uk-active");
        console.log(subid)
        if (subid == undefined) {
            console.log('sub id NOT defined re-activate old class')
            var oldtypebychange = "#cat" + catid + "-sub0";
            $(oldtypebychange).parent().addClass("uk-active");
            CatSelectOld[catid - 1] = 0
        } else {
            console.log('sub id defined: add new class')
            CatSelectOld[catid - 1] = subid
            var newselect = "#cat" + catid + "-sub" + CatSelectOld[catid - 1] + "";
            $(newselect).parent().addClass("uk-active");
        }

        idcache[catid] = subid;

        ids = [];
        for (var k in idcache) { //遍历 对象的每个key/value对,k为key
            if (idcache[k] != undefined) {
                ids.push(idcache[k]);
            }
        }

        getDishFiltered(getCookie("menu"), ids);
    }



    function getDishFiltered(menu_id, type) {
        $("#dishs_area").html("<div uk-spinner='ratio: 5'></div>");
        console.log('type');
        console.log(type)
        $.ajax({
            url: "{{Route('ApiFiltered')}}",
            type: "POST",
            timeout: 10000,
            data: {
                "menu_id": menu_id,
                "type": type
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                //console.log(data);

                if (data == []) {
                    $("#dishs_area").html("ops,vuoto il menu");
                } else {
                    page_all = Math.ceil(data.length / 20);
                    dishs = data;
                    dishs_indexed = _(dishs).indexBy('id');
                    DishSort('number_code');
                    NumberParse(menu_id);
                }
            },
            error: function(data) {
                UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:<em>' + data.responseText + '</em>').then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            }
        });
    }

    function NumberParse(menu_id) {
        if (getCookie("cart") != "" && getCookie("cart") != "{}") {
            cart = JSON.parse(getCookie('cart'));
            delete cart['row_number'];
            cart_array = Object.values(cart);
            cart_array.forEach((element, index) => {
                if (element.menu == menu_id) {
                    htmlElement = document.getElementById("number" + element.dish_id);
                    if (htmlElement) {
                        htmlElement.value = element.number;
                    }
                }

            });
        }

    }

    function DishSort(attribute) {
        menu_id = getCookie('menu');
        if (attribute == 'name') {
            dishs = _.sortBy(dishs, function(item) {
                return item.name.toLowerCase();
            });
        } else if (attribute == 'number_code') {
            console.log('number code sort');
            //console.log(dishs);
            dishs = _(dishs).chain()
                .sortBy('id')
                .sortBy(function(item) {
                    if (item.number_code) {
                        return parseInt(item.number_code);
                    } else {
                        return parseInt(1000);
                    }
                })
                .sortBy(function(item) {
                    if (item.code) {
                        return item.code;
                    } else {
                        return "a";
                    }
                })
                .value();
            //console.log(dishs);
        } else {
            dishs = _.sortBy(dishs, attribute);

        }
        ParseDish(dishs, menu_id);
    }

    function ParseDish(data, menu_id) {
        $("#dishs_area").html("");
        //
        /* <em><del>原价 €</del> </em><br> */
        for (let i = 0; i < data.length; i++) {
            if (data[i].number_code == null) {
                data[i].number_code = '';
            }

            if (data[i].code == null) {
                data[i].code = '';
            }

            var limitstr = '  <span style="color:red">max: ' + data[i].limit + '/persona</span>'
            if (data[i].limit == null) {
                limitstr = ''
            }

            var template_dish = `<tr>\
                <td class="uk-width-1-6 uk-preserve-width"><img style ="width:9em" src="{{asset("")}}${data[i].img}"></td>\
                <td class="uk-width-5-6 uk-text-break">\
                <div>${data[i].code} ${data[i].number_code} ${data[i].name}</div>\
                <div>${data[i].price}€ ${limitstr} </div>\
                <div>\
                <a onclick="Delitem(${data[i].id}, ${menu_id},0)"><i uk-icon="minus-circle"></i></a>\
                <input id="number${data[i].id}" oninput="numberonchange( ${data[i].id} , ${menu_id} , '${data[i].name}')" class="uk-input" style="width:50px;" value="0" type="number" min="0">\
                <a onclick="Additem( ${data[i].id} , ${menu_id} , '${data[i].name}')"><i uk-icon="plus-circle"></i></a></div></td></tr>`;
                /* <a class="uk-visible@m uk-button uk-button-default uk-button-small" href="{{ url("/dish/detail") }}/${data[i].id}" type="button">@lang("messages.Detail")</a> */
            $("#dishs_area").append(template_dish);
        }
    }

    function AddItemCart(id, menu, key) {
        currentMenu = getCookie("menu");
        if (menu == currentMenu) {
            Additem(id, menu, "", cart_key = "", mode = 0)
        } else {
            number = parseInt($("#cart_number_" + key).text()) + 1;

            SetItem("", "", number, "", key, cart_mode = 2);
        }
    }


    function SubItemCart(id, menu, key) {
        currentMenu = getCookie("menu");
        console.log("dish menu and current menu");
        console.log(menu);
        console.log(currentMenu);
        if (menu == currentMenu) {
            Delitem(id, menu, "", cart_key = "", mode = 0)
        } else {
            number = parseInt($("#cart_number_" + key).text()) - 1;

            SetItem("", "", number, "", key, cart_mode = 2);
        }
    }

    function Additem(id, menu, name, mode = 0) {
        var cart = getCookie('cart');
        console.log(id);
        $("#cart_number").text(parseInt($("#cart_number").text())+1);
        if (typeof menu == "undefined" || menu == null || menu == "") {
            menu = getCookie('menu');
        }
        SetItem(id, menu, parseInt(document.getElementById("number" + id).value) + 1, name, "", 0);

    }


    function Delitem(id, menu, name, key = "", number = "") {
        var cart = JSON.parse(getCookie('cart'));
        $("#cart_number").text($("#cart_number").text()-1);
        if (typeof menu == "undefined" || menu == null || menu == "") {
            menu = getCookie("menu");
        }

        if (key != "") {
            @php
            //模式2是修改【购物车】里的数量。
            @endphp
            mode = 2;
            values = parseInt($("#cart_number_" + key).text()) - 1;
        } else {
            //模式0是修改【菜单】里的数量。
            mode = 0;
            values = parseInt(document.getElementById("number" + id).value) - 1;
        }
        if (values >= 0) {
            SetItem(id, menu, values, name, key, 0);
        }

    }

    function SetItem(id, menu, number, name = "", cart_key = "", cart_mode = 0) {

        var cart = getCookie('cart');
        if (cart) {
            var cart = JSON.parse(getCookie('cart'));
        } else {
            console.log('cart doesnt exist, creating cart variable')
            var cart = {};
            cart['row_number'] = 0;
        }

        @php
        //初始化key
        @endphp
        var key = ""
        switch (cart_mode) {
            @php
            //case 0菜单【快速修改】数量，无note
            @endphp
            case 0:
                console.log("cart mode:0");
                key = id.toString() + menu.toString();
                document.getElementById("number" + id).value = number;
                break;
                @php
                //细节上的带有note的【添加】
                @endphp
            case 1:
                key = "note" + cart['row_number'];
                break;

            case 2:
                key = cart_key;
                break;
        }

        @php
        //Number>0 添加模式
        @endphp
        if (number > 0) {
            if (cart[key]) {
                console.log('change existing value');

                cart[key]['number'] = number;
                @php
                //修改购物车里的数字
                @endphp
                $("#cart_number_" + key).text(cart[key]['number']);
            } else {
                @php
                //添加新的一行购物车
                @endphp
                cart[key] = {};
                cart[key]['dish_id'] = id;
                cart[key]['menu'] = menu;
                cart[key]['number'] = number;
                //if (note != "") {
                //    cart[key]['note'] = note;
                //}
                cart['row_number']++;

                @php
                //因为是新的，所以要添加到前台购物车
                @endphp
                console.log('add html to cart');
                var template = `<li id="cart_${key}" style="margin: 30px;">\
                    <div style="margin-bottom: 10px;"><span class="uk-badge">${menu_indexed[menu].name}</span>${name}</div>\
                    <div class="uk-child-width-1-3" style="text-align: center;" uk-grid>\
                        <a class="uk-icon" uk-icon="minus-circle" onclick="SubItemCart(${id} ,${menu}, ${key})"></a> \
                        <div id="cart_number_${key}">${cart[key]['number']}</div> \
                        <a class="uk-icon" uk-icon="plus-circle" onclick="AddItemCart(${id} ,${menu}, ${key})"></a>\
                    </div>\
                </li>`;

                //var template = `<tr id="cart_${key}">\
                //<td>${id}</td>\
                //<td>${name}</td>\
                //<td>${$("#admin_menu").find("option:selected").text()}</td>\
                //<td id="cart_number_${key}">${cart[key]['number']}</td>\
                //<td class="uk-preserve-width"><a class="uk-button uk-button-small uk-button-primary" \
                //onclick="Delitem(${id},${$("#admin_menu").find("option:selected").val()},${tid},${key})">\
                //<i uk-icon="minus-circle"></i></a></td></tr>`;

                $("#cart-area-id").append(template);
                console.log($("#cart-area-id").text());
            }
        }
        @php
        //如果数量等于0就是删除模式（输入错误：小于0也是删除模式）
        @endphp
        else {
            if (cart[key]) {
                delete cart[key];
                cart['row_number']--;
                @php
                //前台购物车删除行
                @endphp
                document.getElementById(`cart_${key}`).remove();
            }
        }

        console.log(cart);
        setCookie('cart', JSON.stringify(cart), 1);

        //return cart;
    }

    function numberonchange(id, menu_id, name) {
        var value = parseInt(document.getElementById("number" + id).value);
        @php
        //禁止＜0的数值
        @endphp
        if (value > 0) {
            SetItem(id, menu_id, value, name, "")
        } else {
            SetItem(id, menu_id, 0, name, "")
        }

    }



    function Delallitem(id, menu, name, key = "") {
        var cart = JSON.parse(getCookie('cart'));
        if (typeof menu == "undefined" || menu == null || menu == "") {
            menu = getCookie('menu');
        }
        SetItem(id, menu, 0, name, key, 2);
        document.getElementById("liid_" + key).remove();
        UIkit.notification({
            message: '<span uk-icon=\'icon: trash\'></span> Dell all ' + name + ' success',
            status: 'danger',
            pos: 'bottom-center'
        });
    }

    var OrderLock = 0;

    function SubmitOrder() {

        if (OrderLock == 0) {
            OrderLock = 1
            cart = {}
            if (getCookie('cart') != "") {
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
</script>
@include('include.footer')

</html>