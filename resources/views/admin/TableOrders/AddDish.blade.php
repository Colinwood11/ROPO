<div class="uk-card uk-card-default">
    <div class="uk-overflow-auto uk-card-body">
        <div class="uk-grid-margin uk-first-column">
            <div uk-grid>
                <div class="uk-width-1-2">
                    <span style="float:left;">
                        <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                            <div class="uk-width-1-1">
                                <button id="filter" class="uk-button-small uk-button-primary" type="button"
                                    uk-toggle="target: #scrollbar"
                                    aria-expanded="true">@lang('messages.Filter')</button>
                            </div>
                        </div>
                    </span>
                </div>
                <div class="uk-width-1-2">
                    <span style="float:right;">
                        <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                            <div class="uk-width-1-6">
                                <label class="uk-form-label" for="form-h-text">Menu</label>
                            </div>
                            <div class="uk-form-controls uk-width-1-1">
                                <select class="uk-select" id="admin_menu" onchange="Change_menu()">
                                    <option value="2">Carta</option>
                                    <option value="4">Cena</option>
                                    <option value="3">Pranzo</option>
                                </select>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
            <div id="scrollbar" class="uk-container">
                @foreach ($cats as $cat)
                <div class="uk-grid-small uk-grid-divider uk-child-width-auto" uk-grid>
                    <h3>{{ $cat['Catname'] }}</h3>
                    <div>
                        <ul class="uk-subnav uk-subnav-pill" uk-margin>
                            <li class="uk-active">
                                <a id="cat{{ $cat['id'] }}-sub0" onclick="changetype({{ $cat['id'] }})">>All</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <ul class="uk-subnav uk-subnav-pill" uk-margin>
                            @foreach ($cat['subcategory'] as $sub)
                            <li>
                                <a id="cat{{ $cat['id'] }}-sub{{ $sub['id'] }}"
                                    onclick="changetype({{ $cat['id'] }},{{ $sub['id'] }})">{{ $sub['name'] }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
        <hr class="uk-margin-medium-top">
        <table class="uk-table uk-table-middle uk-table-justify uk-table-striped uk-table-hover">
            <thead>
                <tr>
                    <th><a onclick="sortDish('number_code')">N.</a></th>
                    <th><a onclick="sortDish('name')">Nome</a></th>
                    <th><a>Azione</a></th>
                </tr>
            </thead>
            <tbody id="dishs_area">
            </tbody>
        </table>
    </div>
</div>
<script>
    var type_idcache = {};
    var type_ids = [];
    var tid = 0;
    var dishs = '';
    var dishs_indexed = '';
    var alldish_array = '';

    function getAllDish() {
        $.ajax({
            url: "{{ Route('ApiDishAll') }}",
            type: "GET",
            timeout: 10000,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                if (data == []) {
                    console.log('get all dish empty');
                } else {
                    alldish_array = data;
                    dishs_indexed = _(data).indexBy('id');
                    initializeFlexList();

                }
            },
            error: function(data) {
                console.log('get all dish err');
                console.log(data.responseText)
            }
        });
    }

    function get(menu_id, type) {
        $("#dishs_area").html("<div uk-spinner='ratio: 5'></div>");
        //setCookie('menu', menu_id, 1);
        console.log("menu id is: " + menu_id);
        console.log(type);
        $.ajax({
            url: "{{ Route('ApiFiltered') }}",
            type: "POST",
            timeout: 3000,
            data: {
                "menu_id": menu_id,
                "type": type
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                if (data == []) {
                    $("#dishs_area").html("ops,il menu e' vuoto");
                } else {
                    page_all = Math.ceil(data.length / 20);
                    dishs = data;
                    console.log('filtered dish');
                    console.log(dishs);
                    sortDish('number_code');
                }
            },
            error: function(data) {
                UIkit.modal.alert(`Error! chieti a assistenza <br> Error data:<em> ${data.responseText}</em>`).then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            }
        });
    }

    function sortDish(attribute) {
        menu_id = MenuGlobal;
        if (attribute == 'name') {
            dishs = _.sortBy(dishs, function(item) {
                return item.name.toLowerCase();
            });
        } else if (attribute == 'number_code') {
            console.log('number code sort');
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
        } else {
            dishs = _.sortBy(dishs, attribute);
        }
        parsedata(dishs, menu_id);
    }

    function parsedata(data, menu_id) {
        $("#dishs_area").html("");
        for (let i = 0; i < data.length; i++) {
            if (data[i].number_code == null) {
                data[i].number_code = '';
            }

            if (data[i].code == null) {
                data[i].code = '';
            }
            var template_dish = `<tr>\
                                <td>${data[i].number_code}</td>\
                                <td onclick="Additem( ${data[i].id} , ${menu_id} , '${data[i].name}')">${data[i].name}</td>\
                                <td><a onclick="Delitem(${data[i].id}, ${menu_id},${tid})"><i uk-icon="minus-circle"></i></a>\
                                <input id="number${data[i].id}" onchange="numberonchange( ${data[i].id} , ${menu_id} , '${data[i].name}')" class="uk-input" style="width:50px;" value="0" type="number" min="0">\
                                <a onclick="Additem( ${data[i].id} , ${menu_id} , '${data[i].name}')"><i uk-icon="plus-circle"></i></a></td></tr>`;
            $("#dishs_area").append(template_dish);
        }
    }

    function numberonchange(id, menu_id, name) {

        SetItem(id, menu_id, parseInt(document.getElementById("number" + id).value), name, "", "")

    }

    function SetItem(id, menu, number, name, note = "", cart_key = "", cart_mode = 0) {

        //初始化cart
        var cart = getCookie('cart');
        if (cart) {
            var cart = JSON.parse(getCookie('cart'));
        } else {
            var cart = {};
            cart['row_number'] = 0;
        }

        //初始化key
        var key = ""
        switch (cart_mode) {
            //case 0菜单【快速修改】数量，无note
            case 0:
                key = id.toString() + menu.toString();
                document.getElementById("number" + id).value = number;
                break;
                //细节上的带有note的【添加】
            case 1:
                key = "note" + cart['row_number'];
                break;

                //购物车【修改】
            case 2:
                key = cart_key;
                break;
        }

        //Number>0 添加模式
        if (number > 0) {
            if (cart[key]) {
                cart[key]['number'] = number;
                //修改购物车里的数字
                $("#cart_number_" + key).text(cart[key]['number']);
            } else {
                cart[key] = {};
                cart[key]['dish_id'] = id;
                cart[key]['menu'] = menu;
                cart[key]['number'] = number;
                if (note != "") {
                    cart[key]['note'] = note;
                }
                cart['row_number']++;


                var template = `<tr id="cart_${key}">\
                <td>${id}</td>\
                <td>${name}</td>\
                <td>${$("#admin_menu").find("option:selected").text()}</td>\
                <td id="cart_number_${key}">${cart[key]['number']}</td>\
                <td class="uk-preserve-width"><a class="uk-button uk-button-small uk-button-primary" \
                onclick="Delitem(${id},${$("#admin_menu").find("option:selected").val()},${tid},${key})">\
                <i uk-icon="minus-circle"></i></a></td></tr>`;

                $("#tbody-id").prepend(template);
            }
        }
        //如果数量等于0就是删除模式（bug情况，小于0也是删除模式）
        else {
            if (cart[key]) {
                delete cart[key];
                cart['row_number']--;
                document.getElementById(`cart_${key}`).remove();
            }
        }

        //console.log(cart);
        setCookie('cart', JSON.stringify(cart), 1);

        //return cart;
    }

    function Additem(id, menu_id, name, note = "") {

        var menu = MenuGlobal;
        SetItem(id, menu, parseInt(document.getElementById("number" + id).value) + 1, name, "", "", 0);

    }

    function Delitem(id, menu, tid, key = "") {
        if (key != "") {
            mode = 2;
            values = parseInt($("#cart_number_" + key).text()) - 1;
        } else {
            mode = 0;
            values = parseInt(document.getElementById("number" + id).value) - 1;
        }
        if (values >= 0) {
            SetItem(id, menu, values, "", key, mode);
        }

    }

    var CatSelectOld = [0, 0, 0, 0]

    function changetype(catid, subid) {

        var oldtypebychange = "#cat" + catid + "-sub" + CatSelectOld[catid - 1];

        $(oldtypebychange).parent().removeClass("uk-active");

        if (subid == undefined) {
            console.log('sub id NOT defined re-activate old class')

            var oldtypebychange = "#cat" + catid + "-sub0";

            $(oldtypebychange).parent().addClass("uk-active");

            CatSelectOld[catid - 1] = 0
        } else {
            CatSelectOld[catid - 1] = subid
            var newselect = "#cat" + catid + "-sub" + CatSelectOld[catid - 1] + "";
            $(newselect).parent().addClass("uk-active");
        }

        type_idcache[catid] = subid;

        type_ids = [];
        for (var k in type_idcache) { //遍历 对象的每个key/value对,k为key  
            if (type_idcache[k] != undefined) {
                type_ids.push(type_idcache[k]);
            }
        }

        get(MenuGlobal, type_ids);
    }

    var MenuGlobal = '';

    function Change_menu() {
        MenuGlobal = document.getElementById("admin_menu").value;
        get(MenuGlobal, type_ids);
        ChangeMenuAjax(menu_id);

    }
    //var insertUrl = new String("{{ Route('OrderInsertStaff') }}");

    function InitMenu() {

        if (Table.menu_id) {
            console.log('using preset menu.');
            MenuGlobal = Table.menu_id;
            document.getElementById("admin_menu").value = MenuGlobal;
        } else {
            console.log('using default menu.');
            MenuGlobal = document.getElementById("admin_menu").value;
        }
        ChangeMenuAjax(MenuGlobal);
        console.log(MenuGlobal);
        get(MenuGlobal, type_ids);
    }

    function ChangeMenuAjax(menu_id) {
        $.ajax({
            url: "{{ Route('TableChangeMenu') }}",
            type: "POST",
            data: {
                "id": Table.id,
                "menu_id": menu_id
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {

            },
            error: function(data) {
                UIkit.modal.alert(`Errore cambio menu tavolo! chieti a assistenza <br>Error data: ${data.responseText}`)
                    .then(function() {
                        console.log(data.responseText)
                        console.log('Alert closed.')
                    });
            },
            timeout: 10000
        });
    }

    var OrderLock = 0;

    function SendOrder() {

        if (OrderLock == 0) {
            OrderLock = 1;
            console.log('locking the print..');
            var cart = {}
            if (getCookie('cart') != "") {
                cart = JSON.parse(getCookie('cart'));
                delete cart['row_number'];
            }
            console.log(cart);
            if (_.isEmpty(cart) == false) {
                cart = Object.values(cart);
                $.ajax({
                    url: "{{ Route('ApiOrderInsertGuest') }}",
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
                        UIkit.modal.alert('OK！').then(function() {
                            console.log('Alert closed.')
                            window.location.reload();
                        });
                    },
                    error: function(data) {
                        setCookie('cart', "", 1);
                        UIkit.modal.alert(`Error! chieti a assistenza <br>Error data: ${data.responseText}`)
                            .then(function() {
                                console.log(data.responseText)
                                console.log('Alert closed.')
                            });
                    },
                    timeout: 10000
                });
            } else {
                UIkit.modal.alert('Non hai scelto piati ancora, vai a ordinare！').then(function() {
                    console.log('Alert closed.')
                });
                OrderLock = 0;
            }
        } else {
            console.log('already locked');
        }
    }
</script>