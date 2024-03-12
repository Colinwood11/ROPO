@extends('admin.template')
@section('content')

@php
//TODO:convert into javascript at future
if(isset($dish))
{
$dish_subs = array_column($dish['type'],'subcategory_id');
}
@endphp
<div class="uk-card uk-card-default">
    <div class="uk-card-body">
        <div class="uk-container">
            <div uk-grid class="uk-grid">
                <form class='uk-form-horizontal uk-first-column'>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-text" style="color: #666;">Dish Name</label>
                        <div class="uk-form-controls">
                            <input class="uk-input uk-form-width-large" id="dishname" type="text" name="name" placeholder="name" @isset($update) value="{{$dish['name']}}" @endisset>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-select" style="color: #666;">Status</label>
                        <div class="uk-form-controls">
                            <select class="uk-select uk-form-width-large" name="status" id="dish_status">
                                <option>Active</option>
                                <option>Disable</option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-text" style="color: #666;">Number</label>
                        <div class="uk-form-controls">
                            <input class="uk-input uk-form-width-large" id="number_code" type="number" name="name" placeholder="example:25" @isset($update) value="{{$dish['number_code']}}" @endisset>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-text" style="color: #666;">Code</label>
                        <div class="uk-form-controls">
                            <input class="uk-input uk-form-width-large" id="code" type="text" name="name" placeholder="example:c" @isset($update) value="{{$dish['code']}}" @endisset>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-select" style="color: #666;">Printer</label>
                        <div class="uk-form-controls">
                            <select class="uk-select uk-form-width-large" name="status" id="dish_printer">
                                <option value="0">Bar</option>
                                <option value="1">Kitchen</option>
                                <option value="2">Sushi</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-text" style="color: #666;">Picture Name</label>
                        <div class="uk-form-controls">
                            <input class="uk-input uk-form-width-large" id="img" type="text" name="name" placeholder="example.jpg" @isset($update) value="{{$dish['img']}}" @endisset>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-select" style="color: #666;">Menu</label>
                        <div class="uk-form-controls uk-form-width-large">
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                                @foreach($menus as $menu)<li><a href="#">{{$menu['name']}}</a></li>@endforeach
                            </ul>

                            <ul class="uk-switcher uk-margin">

                                @foreach($menus as $menu)
                                <li>
                                    <div class="uk-card-body uk-card-default uk-margin" id="{{$menu['name']}}Menu">

                                        <div class="uk-container">
                                            <label><input class="uk-checkbox dish_menus" type="checkbox" id='menu_{{$menu['id']}}' @if(isset($menu['HasDish']) && $menu['HasDish']==1) checked @endif> Enable</label><br>
                                            <div class="uk-margin-small">
                                                <input class="uk-input" type="decimal" placeholder="price" id="menuprice_{{$menu['id']}}" @if(isset($menu['HasDish']) && $menu['HasDish']==1) value="{{$menu['dish_menu'][0]['price']}}" @else value="0" @endif>
                                            </div>

                                            <label><input class="uk-checkbox" type="checkbox" id="discount_{{$menu['id']}}" @if(isset($menu['discount']) && $menu['discount']==true) checked @endif onclick="ToggleDiscount('{{$menu['id']}}')"> discount</label>
                                            <input class="uk-input" type="decimal" placeholder="insert a price.." id="discountprice_{{$menu['id']}}" @if(isset($menu['discount']) && $menu['discount']==true) value="{{$menu['dish_menu'][0]['discounted_price']}}" @endif @if(isset($menu['discount'])==false || $menu['discount']==false) disabled='' @endif>
                                            <div class="uk-margin-small uk-grid-small uk-child-width-1-2 uk-grid" uk-grid="">
                                                <div class="uk-first-column">
                                                    <input class="uk-input" id="discountstart_{{$menu['id']}}" type="datetime-local" value="@if(isset($menu['dish_menu'][0]['start_discount'])){{\Carbon\Carbon::parse($menu['dish_menu'][0]['start_discount'])->format('Y-m-d')}}T{{\Carbon\Carbon::parse($menu['dish_menu'][0]['start_discount'])->format('H:i')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}T{{\Carbon\Carbon::now()->format('H:i')}}@endif" @if(isset($menu['discount'])==false || $menu['discount']==false) disabled='' @endif>
                                                </div>
                                                <div>
                                                    <input class="uk-input" id="discountend_{{$menu['id']}}" type="datetime-local" value="@if(isset($menu['dish_menu'][0]['end_discount'])){{\Carbon\Carbon::parse($menu['dish_menu'][0]['end_discount'])->format('Y-m-d')}}T{{\Carbon\Carbon::parse($menu['dish_menu'][0]['end_discount'])->format('H:i')}}@else{{\Carbon\Carbon::now()->format('Y-m-d')}}T{{\Carbon\Carbon::now()->format('H:i')}}@endif" @if(isset($menu['discount'])==false || $menu['discount']==false) disabled='' @endif>
                                                </div>
                                            </div>
                                            <div class="uk-margin-small uk-grid-small uk-child-width-1-2 uk-grid" uk-grid="">
                                                <div class="uk-first-column">
                                                    <label><input class="uk-checkbox" type="checkbox" id="limit_{{$menu['id']}}" @isset($menu['dish_menu'][0]['limit']) checked @endisset onclick="ToggleNumber('{{$menu['id']}}')"> limit number</label>
                                                </div>
                                                <div>
                                                    <input class="uk-input disabled" type="number" min="1" id="limitNumber_{{$menu['id']}}" placeholder="insert a number..." value="@isset($menu['dish_menu'][0]['limit']){{$menu['dish_menu'][0]['limit']}}@endisset" @if(isset($menu['dish_menu'][0]['limit'])==false) disabled='' @endif>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-h-select" style="color: #666;">Menu</label>
                        <div class="uk-form-controls uk-form-width-large">
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                                @foreach ($cats as $cat)<li><a href="#">{{ $cat["Catname"] }}</a></li>@endforeach
                            </ul>
                            <ul class="uk-switcher uk-margin">
                                @foreach ($cats as $cat)
                                <li>
                                    <div class="uk-card-body uk-card-default uk-margin" id="{{$menu['name']}}Menu">

                                        <div class="uk-container">
                                            @foreach ($cat["subcategory"] as $sub)
                                            <div>
                                                <input class="uk-checkbox dish_subcategory" type="checkbox" id="Sub{{$sub['id']}}" @php if(isset($dish) && in_array($sub['id'],$dish_subs)) { echo('checked'); } @endphp onclick="changesub({{$sub['id']}})"> {{$sub['name']}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="uk-panel uk-column-1-1 uk-column-1-2@m">
                        <div class="uk-column-1-1">
                            <a class="uk-button uk-button-primary">Reset</a>

                        </div>
                        <div class="uk-column-1-1">
                            <a class="uk-button uk-button-primary" onclick="UpdateAddDish()">Submit</a>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</div>


</div>

<script>
    //POST 编辑
    var dish = null;
    var dish_type = [];
    var update = 0;
    var PostUrl = "{{Route('ApiDishInsert')}}";
    //var dish_menu = [];
    @if(isset($update))
    console.log('update mode parsing values..');
    dish = @json($dish);
    dish_type = @json(array_column($dish['type'], 'subcategory_id'));
    PostUrl = "{{Route('ApiDishUpdate')}}";
    update = 1;
    console.log(dish_type);
    console.log(dish);
    document.getElementById("dish_printer").value = dish.printer;
    @endif console.log($('meta[name="_token"]').attr('content'));

    function UpdateAddDish() {

        dish_post = {};
        dish_post.dish_menu = ParseMenuNoID();
        if (update == 1) {
            dish_post.id = dish.id;
            dish_post.type = typeParse(dish.id);
            MenuAddId(dish_post.dish_menu, dish.id);
        }
        else
        {
            dish_post.type = typeParseNoID();
        }
        dish_post.name = document.getElementById("dishname").value;
        dish_post.status = document.getElementById("dish_status").value;
        dish_post.printer = document.getElementById("dish_printer").value;
        dish_post.number_code = document.getElementById("number_code").value;
        dish_post.code = document.getElementById("code").value;
        dish_post.img = document.getElementById("img").value;
        console.log(dish_post);
        AjaxPost(dish_post);

    }

    function AjaxPost(body) {
        $.ajax({
            url: PostUrl,
            type: "POST",
            data: body,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                console.log(data);
                UIkit.modal.alert('Modificato con successo').then(function() {
                    console.log('Alert closed.')
                    window.location.replace("{{Route('DishList')}}");
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

    function typeParseNoID(id) {
        type = [];
        for (i = 0; i < dish_type.length; i++) {
            type.push({
                'subcategory_id': dish_type[i]
            });
        }
        return type;
    }

    function typeParse(id) {
        type = [];
        for (i = 0; i < dish_type.length; i++) {
            type.push({
                'dish_id': id,
                'subcategory_id': dish_type[i]
            });
        }
        return type;
    }

    function MenuAddId(menus, id) {
        menus.forEach(function(menu, index, arr) {
            menu.dish_id = id;
        });

    }

    function ParseMenuNoID() {

        var menus_result = [];
        var menus = document.getElementsByClassName('dish_menus');
        //FIX THE BUG!
        for (i = 0; i < menus.length; i++) {
            menu = menus.item(i);
            if (menu.checked == true) {
                var menu_element = {};
                menu_element.menu_id = menu.id.split('_')[1];
                menu_element.price = document.getElementById('menuprice_' + menu_element.menu_id).value;
                if (document.getElementById('discount_' + menu_element.menu_id).checked == 1) {
                    menu_element.discounted_price = document.getElementById('discountprice_' + menu_element.menu_id).value;
                    menu_element.start_discount = document.getElementById('discountstart_' + menu_element.menu_id).value;
                    menu_element.end_discount = document.getElementById('discountend_' + menu_element.menu_id).value;
                }
                if (document.getElementById('limit_' + menu_element.menu_id).checked == 1) {
                    menu_element.limit = document.getElementById('limitNumber_' + menu_element.menu_id).value;
                }
                menus_result.push(menu_element);
            }
        }
        return menus_result;
    }

    function changesub(sub_id) {
        checkbox = document.getElementById("Sub" + sub_id);
        if (checkbox.checked == true) {
            console.log('box checked: adding type into array');
            dish_type.push(sub_id);
            console.log(dish_type);
        } else {
            console.log('box disabled: deleting id from array');
            dish_type.splice(dish_type.indexOf(sub_id), 1);
            console.log(dish_type);
        }
    }


    function ToggleDiscount(menu) {

        ToggleElement(document.getElementById("discountstart_" + menu));
        ToggleElement(document.getElementById("discountend_" + menu));
        ToggleElement(document.getElementById("discountprice_" + menu));
    }

    function ToggleElement(element) {
        element.disabled = !element.disabled;
    }

    function ToggleNumber(menu) {
        number = document.getElementById("limitNumber_" + menu);
        ToggleElement(number);
        number.value = null;
    }
</script>

@stop

</html>