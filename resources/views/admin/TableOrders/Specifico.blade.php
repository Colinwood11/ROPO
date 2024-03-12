<div class="uk-card uk-card-default">
    <div class="uk-overflow-auto uk-card-body">
        <div uk-grid>
            <div class="uk-width-1-2">
                <span style="float:left;">
                    <label ><input class="uk-checkbox" type="checkbox" checked id="print_update" > Stampare</label>
                    <button class="uk-button uk-button-primary uk-button-small" type="button" id="update-button" onclick="UpdateAddOrder()" disabled >Conferma</button>
                </span>
            </div>
            <div class="uk-width-1-2">
                <span style="float:right;">
                            
                </span>
            </div>
        </div>
                 
        <div class="uk-overflow-auto">
            @isset($orders['table_history'][0])
            <table class="uk-table uk-table-striped uk-table-small uk-table-hover" style="width: 1000px;">
                <thead>
                    <tr>
                        <th style="width: 200px;">@lang('messages.dish')</th><!-- class="uk-table-shrink" -->
                        <th class="uk-table-preserve-width" style="width: 90px;">Quantita'</th><!--Totale/Rimanente/Selezionato -->
                        <th class="uk-table-shrink" style="width: 90px;">@lang('messages.menu')</th>
                        <th class="uk-table-shrink" style="width: 60px;" >Prezzo Totale</th>
                        <th class="uk-table-shrink" >Resetta</th>
                    </tr>
                </thead>
                
                <tbody>
                    
                    @foreach ($orders['order_stacked'] as $order_stacked)
                        <tr>
                            <td style="color:#666;">
                                <div class="uk-inline">
                                    <a class="uk-form-icon uk-form-icon-flip uk-icon" href="#" onclick="ClearDish({{$order_stacked['orders'][0]['id']}},false)" uk-icon="icon: close"></a>
                                    <input class="uk-input dish-list" id="update-dish-order-{{$order_stacked['orders'][0]['id']}}" type="text" onchange="ChangeOrderUpdateDish({{$order_stacked['orders'][0]['id']}},false)">
                                </div>
                                <small>id:<span style="color:green;" id="value-dish-order-{{$order_stacked['orders'][0]['id']}}"></span></small>
                            </td>
                            <td style="color:#666;">
                                <a onclick="UpdateMinusOne({{$order_stacked['orders'][0]['id']}},false)"><i uk-icon="minus-circle"></i></a>
                                <input class="uk-input"
                                    style="width: 70px;"
                                    oninput="ChangeOrderUpdateNumber({{$order_stacked['orders'][0]['id']}},false)" 
                                    id="update-number-order-{{$order_stacked['orders'][0]['id']}}" 
                                    type="number"
                                    min='0' 
                                    placeholder="insert a number..." 
                                    value='{{$order_stacked['orders'][0]['number']}}'>
                                <a onclick="UpdateAddOne({{$order_stacked['orders'][0]['id']}},false)"><i uk-icon="plus-circle"></i></a> 
                            </td>
                            <td style="color:#666;">
                                <select class="uk-select" id="update-menu-order-{{$order_stacked['orders'][0]['id']}}" oninput="ChangeOrderUpdateMenu({{$order_stacked['orders'][0]['id']}},false)">
                                    @foreach($menus as $menu)
                                        @if($menu['id'] == $order_stacked['orders'][0]['menu'])
                                            <option value={{$menu['id']}} selected >{{$menu['name']}}</option>
                                        @else
                                            <option value={{$menu['id']}} >{{$menu['name']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>
                            <td style="color:#666;">                                
                                <input class="uk-input" 
                                style="width: 120px;" 
                                id="update-price-order-{{$order_stacked['orders'][0]['id']}}" 
                                type="number" 
                                min='0' 
                                step='.01' 
                                oninput="ChangeOrderUpdatePrice({{$order_stacked['orders'][0]['id']}},false)"
                                placeholder="automatico"
                                value="{{$order_stacked['orders'][0]['number'] * $order_stacked['orders'][0]['price']}}">
                            </td>
                            <td style="color:#666;">
                                <a class="uk-button uk-button-primary uk-button-small" onclick="UpdateReset({{$order_stacked['orders'][0]['id']}},false)"><i uk-icon="refresh"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            Ordine in attesa Stampa
            <table class="uk-table uk-table-striped uk-table-small uk-table-hover" style="width: 1000px;">
                <thead>
                    <tr>
                        <th style="width: 200px;">@lang('messages.dish')</th><!-- class="uk-table-shrink" -->
                        <th class="uk-table-preserve-width" style="width: 90px;">Quantita'</th><!--Totale/Rimanente/Selezionato -->
                        <th class="uk-table-shrink" style="width: 90px;">@lang('messages.menu')</th>
                        <th class="uk-table-shrink" style="width: 60px;" >Prezzo Totale</th>
                        <th class="uk-table-shrink" >Resetta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordersque['table_history'][0]['orderque'] as $order)
                    <tr>
                        <td style="color:#666;">
                            <div class="uk-inline">
                                <a class="uk-form-icon uk-form-icon-flip uk-icon" href="#" onclick="ClearDish({{$order['id']}},true)" uk-icon="icon: close"></a>
                                <input class="uk-input dish-list" id="update-dish-orderque-{{$order['id']}}" type="text" onchange="ChangeOrderUpdateDish({{$order['id']}},true)">
                            </div>
                            <small>id:<span style="color:green;" id="value-dish-orderque-{{$order['id']}}"></span></small>
                        </td>
                        <td style="color:#666;">
                            <a onclick="UpdateMinusOne({{$order['id']}},true)"><i uk-icon="minus-circle"></i></a>
                            <input class="uk-input" 
                                oninput="ChangeOrderUpdateNumber({{$order['id']}},true)"  
                                id="update-number-orderque-{{$order['id']}}" 
                                style="width: 70px;"
                                type="number" 
                                min='0' 
                                value='{{$order['number']}}'>
                                <a onclick="UpdateAddOne({{$order['id']}},true)"><i uk-icon="plus-circle"></i></a> 
                        </td>
                        <td style="color:#666;">
                            <select class="uk-select" id="update-menu-orderque-{{$order['id']}}" oninput="ChangeOrderUpdateMenu({{$order['id']}},true)">
                                @foreach($menus as $menu)
                                    @if($menu['id'] == $menus[$order['menu']]['id'])
                                        <option value={{$menu['id']}} selected >{{$menu['name']}}</option>
                                    @else
                                        <option value={{$menu['id']}} >{{$menu['name']}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </td>
                        <td style="color:#666;">                            
                            <input  class="uk-input" 
                                style="width: 120px;" 
                                id="update-price-orderque-{{$order['id']}}" 
                                type="number" 
                                min='0' 
                                step='.01' 
                                value="{{$order['price'] * $order['number']}}"
                                placeholder="automatico"
                                oninput="ChangeOrderUpdatePrice({{$order['id']}},true)"
                                > 
                            </td>
                            <td style="color:#666;">
                                <a class="uk-button uk-button-primary uk-button-small" onclick="UpdateReset({{$order['id']}},true)"><i uk-icon="refresh"></i></a>
                            </td>                            
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endisset
        </div>
    </div>
</div>

<!-- This is the modal for confirming the order-->
<div id="modal-confirm_order" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Conferma Ordine</h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Quantita'</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="confirm_num" type="number" min='0' max='5' placeholder="insert a number..." value="1">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close uk-button-small" type="button">Cancella</button>
            <button class="uk-button uk-button-primary uk-button-small" type="button" onclick="ConfirmOrder()">Conferma</button>
            <button class="uk-button uk-button-primary uk-button-small" type="button" onclick="ConfirmOrder(1)">Conferma Tutto</button>
        </div>
    </div>
</div>

<!-- This is the modal for partial checkout-->
<div id="modal-partial-checkout" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical" style="width:1000px;">
        <button class="uk-modal-close-default" type="button" onclick="CloseCheckoutModal()" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Checkout Parziale</h2>
        </div>
        <div class="uk-modal-body">
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-3">
                        <label class="uk-form-label" for="form-h-text" style="text-align: center;">Numero Persone</label>
                    </div>
                    <div class="uk-form-controls uk-width-2-3">
                        <input class="uk-input uk-form-width-large" id="checkout_num_person" type="number" min='1' value="1">
                    </div>
                </div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" style="text-align: center;">Totale Piatto</label>
                    </div>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="total_dish_price" style="text-align: center;">9999.00€</label>
                    </div>

                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" style="text-align: center;">Totale Menu</label>
                    </div>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="total_menu_price" style="text-align: center;">9999.00€</label>
                    </div>

                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" style="text-align: center;">Totale Cassa</label>
                    </div>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="total_cash_price" style="text-align: center;">19998.00€</label>
                    </div>
                </div>
            </div>

            <div class="uk-overflow-auto">
                @isset($orders['table_history'][0])
                <table class="uk-table uk-table-striped uk-table-small uk-table-hover" style="width: 840px;">
                    <thead>
                        <tr>
                            <th class="uk-table-shrink"> </th>
                            <th style="width: 200px;">@lang('messages.dish')</th><!-- class="uk-table-shrink" -->
                            <th class="uk-table-shrink">@lang('messages.menu')</th>
                            <th class="uk-table-shrink" style="width: 150px; text-align:center;">T/R/S</th><!--Totale/Rimanente/Selezionato -->
                            <th class="uk-table-shrink">Prezzo Totale</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach ($orders['order_stacked'] as $order_stacked)
                            <tr>
                                <td class="uk-table-shrink">
                                    <input class="uk-checkbox" type="checkbox" id="checkbx-select-{{$order_stacked['orders'][0]['id']}}" onclick="SwapSelection({{$order_stacked['orders'][0]['id']}})">
                                </td>
                                <td  onclick="SelectCheckBox({{$order_stacked['orders'][0]['id']}})" style="color:#666;">{{ $order_stacked['dish'] }}</td>
                                <td  onclick="SelectCheckBox({{$order_stacked['orders'][0]['id']}})" style="color:#666;">{{ $order_stacked['menu'] }}</td>
                                <td style="color:#666;" align="center">
                                    <span id="number-info-{{$order_stacked['orders'][0]['id']}}">{{$order_stacked['orders'][0]['number']}} / {{$order_stacked['orders'][0]['number']-1}} / </span>
                                    <input class="uk-input" 
                                        oninput="ChangeCheckoutNumber({{$order_stacked['orders'][0]['id']}},false)" 
                                        style="width: 60px;" 
                                        id="number-order-{{$order_stacked['orders'][0]['id']}}" 
                                        type="number" 
                                        min='1' 
                                        max='{{$order_stacked['orders'][0]['number']}}' 
                                        placeholder="insert a number..." 
                                        value="1">
                                    </td>
                                <td style="color:#666;">
                                    <input class="uk-input" 
                                    style="width: 120px;" 
                                    id="price-order-{{$order_stacked['orders'][0]['id']}}" 
                                    type="number" 
                                    min='0' 
                                    step='.01' 
                                    oninput="ChangeCheckoutPrice({{$order_stacked['orders'][0]['id']}},false)"
                                    value="@if($order_stacked['orders'][0]['price'] != '0.00'){{ $order_stacked['orders'][0]['price']}}@endif">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                Ordine in attesa Stampa
                <table class="uk-table uk-table-striped uk-table-small uk-table-hover" style="width: 840px;">
                    <thead>
                        <tr>
                            <th class="uk-table-shrink"> </th>
                            <th >@lang('messages.dish')</th><!-- class="uk-table-shrink" -->
                            <th class="uk-table-shrink">@lang('messages.menu')</th>
                            <th class="uk-table-shrink" style="width: 120px; text-align:center;">T/R/S</th>
                            <th class="uk-table-shrink">Prezzo Totale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordersque['table_history'][0]['orderque'] as $order)
                        <tr>
                            <td class="uk-table-shrink">
                                <input class="uk-checkbox" type="checkbox" id="checkbx-select-que-{{$order['id']}}" onclick="SwapSelection({{$order['id']}},true)">
                            </td>
                            <td  onclick="SelectCheckBox({{$order['id']}},true)" style="color:#666;">{{ $order['dish']['name'] }}</td>
                            <td  onclick="SelectCheckBox({{$order['id']}},true)" style="color:#666;">{{ $menus[$order['menu']]['name'] }}</td>
                            <td style="color:#666;"  style="text-align: center; width:150px;" >
                                <span id="number-info-que-{{$order['id']}}">{{$order['number']}} / {{$order['number']-1}} / </span>
                                <input class="uk-input" 
                                    oninput="ChangeCheckoutNumber({{$order['id']}},true)" 
                                    style="width: 60px;" 
                                    id="number-orderque-{{$order['id']}}" 
                                    type="number" 
                                    min='0' 
                                    max='{{ $order['number'] }}' 
                                    value="1">
                            </td>
                            <td style="color:#666;">
                                <input  class="uk-input" 
                                    style="width: 120px;" 
                                    id="price-orderque-{{$order['id']}}" 
                                    type="number" 
                                    oninput="ChangeCheckoutPrice($order['id'],true)"
                                    min='0' 
                                    step='.01' 
                                    value="@if($order['price'] != '0.00'){{$order['price']}}@endif"> </td>                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endisset
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close uk-button-small" onclick="CloseCheckoutModal()" type="button">Cancella</button>
            <button class="uk-button uk-button-primary uk-button-small" type="button" onclick="CashOrderSelected()">Checkout</button>
        </div>
    </div>
</div>

<script>

    //TODO:fetch price from dish menu
    //TODO:alert when menu doesnt have dish/ dish is not in this menu
    //TODO:hide submit update button when there is no update

    //GLOBAL VARIABLE
    var tableorders = @json($orders);
    var Orders = tableorders.table_history[0].ordering_now;
    var Orderid = 0;
    var update = 1;
    var cash_selection = [];
    //CHECKOUT VARIABLE
    var ids ={};
    var queids ={};

    //BULk UPDATE
    var UpdateIds ={};
    var QueUpdateIds ={};

    //document.getElementById("modal-partial-checkout").addEventListener("hidden",function(){
    //    console.log('partial checkout closed');
    //});

    function CheckButtonStatus() {

        if(_.isEmpty(UpdateIds) && _.isEmpty(QueUpdateIds)){
            console.log('update list empty, disabled button');
            $('#update-button').attr("disabled", "true"); // 添加disabled属性
        }else{
            console.log('update list filled, reveal button');
            $('#update-button').removeAttr("disabled");   // 移除disabled属性
        }
    }
    
    function initializeFlexList() {

        alldish_array.forEach(function (element) {
            element['id'] = element['id'].toString();
        });

        $('.dish-list').flexdatalist({
            data: alldish_array,
            searchContain: false,
            searchByWord: true,
            selectionRequired: true,
            textProperty: '{name}',
            valueProperty: 'id',
            minLength: 1,
            visibleProperties: ["name","numbercode"],
            searchIn: ["name","code","number_code","numbercode"]
        });

        OrdersArray = Object.values(Orders);
        OrderqueArray = Object.values(Orderque);
        OrdersArray.forEach(function(element){
            $("#update-dish-order-"+element['id']).flexdatalist('value',element['dish_id']);
            $("#value-dish-order-"+element['id']).text(element['dish_id']);
        });
        
        OrderqueArray.forEach(function(element) {
            $("#update-dish-orderque-"+element['id']).flexdatalist('value',element['dish_id']);
            $("#value-dish-orderque-"+element['id']).text(element['dish_id']);
        });

    }
    
    var DishMenuIndexed = {};
    function GetDishMenu(){
        $.ajax({
                url: "{{ Route('ApiDishMenuAll') }}",
                type: "GET",
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    console.log(data);
                    data.forEach(function(dishmenu){
                        key = ''+dishmenu.dish_id + dishmenu.menu_id;
                        DishMenuIndexed[key] = dishmenu;
                    });
                },
                error: function(data) {
                    UIkit.modal.alert('Errore del sistema! chieti a assistenza <br>' + 'Error data:' + data.responseText)
                        .then(function() {
                            console.log(data.responseText)
                            console.log('Alert closed.')
                        });
                },
                timeout: 10000
            });
    }

    function BulkEditModal(){
        lockHistory();
        UIkit.modal(document.getElementById("modal-bulk-edit")).show();
    }

    function OrdersIndex(){
        IndexedOrder ={};
        Orders.forEach(function(order){IndexedOrder[order.id] = order;});
        Orders = IndexedOrder;
    }


    function OrderQueIndex(){
        IndexedQue ={};
        Orderque.forEach(function(order){IndexedQue[order.id] = order;});
        Orderque = IndexedQue;
    }


    

    function PartialCheckOutModal(){
        lockHistory();
        UIkit.modal(document.getElementById("modal-partial-checkout")).show();
    }

    function ChangeOrderUpdateDish(id,que=false) {
        console.log('change recorded: '+ id);
        if(que){
            dish_input_id = "#update-dish-orderque-"+id;
            show_text_id = "#value-dish-orderque-"+id;
            OrderBulk = Orderque; 
            BulkIds = QueUpdateIds; //by ref
            priceElem = document.getElementById('update-price-orderque-'+id);
        }
        else{
            dish_input_id = "#update-dish-order-"+id;
            show_text_id = "#value-dish-order-"+id;
            OrderBulk = Orders; 
            BulkIds = UpdateIds; //by ref
            priceElem = document.getElementById('update-price-order-'+id);
        }


        value = $(dish_input_id).flexdatalist('value');
        @php
        //如果数值一样有2种可能，一种是第一次parse数值，啥都不需要做。
        //第二种是从其他的菜又改回来了。这个时候删掉原来的数值就行了。
        @endphp
        if(!value){
            return;
        }
        if(value == OrderBulk[id]['dish_id']){
            console.log('dish update: old dish');
            if(BulkIds[id]){
                delete BulkIds[id]['dish_id'];
            }
            setPrice = OrderBulk[id]['price'];
        }
        else{
            console.log('dish update: new dish');
            if(!BulkIds[id]){
                BulkIds[id] = {};
                BulkIds[id]['id'] = id;  
            }
            BulkIds[id]['dish_id'] = value;
            if(BulkIds[id]['menu']){
                key=''+value+BulkIds[id]['menu'];
            }else{
                key=''+value+OrderBulk[id]['menu'];
            }

            if(DishMenuIndexed[key]){
                console.log('dish menu exists: update price');
                console.log(DishMenuIndexed[key]);
                BulkIds[id]['price'] = DishMenuIndexed[key]['price'];
                setPrice = DishMenuIndexed[key]['price'];
                
            }else{
                
                dishname = $(dish_input_id).flexdatalist('text');
                messages = "{{__('messages.dish_menu_not_exist')}}"+dishname;
                UIkit.modal.alert(messages);

                priceElem.value = 0;
                BulkIds[id]['price'] = 0;
            }

        }

        if(BulkIds[id]['number']){
            priceElem.value = setPrice * BulkIds[id]['number'];
        }else{
            priceElem.value = setPrice * OrderBulk[id]['number'];
        }
        
        $(show_text_id).text(value);
        CheckButtonStatus();
    }

    

    function UpdateReset(id,que=false){
        if(que){
            console.log('orderque reset');
            OrderBulk = Orderque; 
            BulkIds = QueUpdateIds; //by ref
            document.getElementById('update-number-orderque-'+id).value = OrderBulk[id].number; //number
            document.getElementById('update-price-orderque-'+id).value = OrderBulk[id].price*OrderBulk[id].number; //price
            document.getElementById('update-menu-orderque-'+id).value = OrderBulk[id].menu;  //menu
            $("#update-dish-orderque-"+id).flexdatalist('value',OrderBulk[id]['dish_id']);
        }else{
            console.log('order reset');
            OrderBulk = Orders; 
            BulkIds = UpdateIds; //by ref
            
            document.getElementById('update-number-order-'+id).value = OrderBulk[id].number; //number
            document.getElementById('update-price-order-'+id).value = OrderBulk[id].price*OrderBulk[id].number; //price
            document.getElementById('update-menu-order-'+id).value = OrderBulk[id].menu;  //menu 
            $("#update-dish-order-"+id).flexdatalist('value',OrderBulk[id]['dish_id']);       
        }
        //dish
        //ChangeOrderUpdateDish(id,que);
        delete BulkIds[id];
        CheckButtonStatus();
    }

    function UpdateAddOne(id,que=false){
        if(que){
            element = document.getElementById('update-number-orderque-'+id);
        }
        else{
            element = document.getElementById('update-number-order-'+id);
        }
        number = parseInt(element.value) +1;
        element.value = number;
        ChangeOrderUpdateNumber(id,que);

    }

    function UpdateMinusOne(id,que=false){
        if(que){
            element = document.getElementById('update-number-orderque-'+id);
        }
        else{
            element = document.getElementById('update-number-order-'+id);
        }
        
        number = parseInt(element.value);
        if(number -1 >= 0){
            number --;
        }
        element.value = number;
        ChangeOrderUpdateNumber(id,que);
    }

    function ChangeOrderUpdateNumber(id,que=false){
        if(que){
            console.log('orderque change number');
            number = document.getElementById('update-number-orderque-'+id).value;
            OrderBulk = Orderque; 
            BulkIds = QueUpdateIds; //by ref
            price = document.getElementById('update-price-orderque-'+id);

        }else{
            console.log('order change number');
            number = document.getElementById('update-number-order-'+id).value;
            OrderBulk = Orders; 
            BulkIds = UpdateIds; //by ref
            price = document.getElementById('update-price-order-'+id);
        }
        
        if(number == OrderBulk[id].number){
            //remove attribute from the array
            console.log("number is same as old.");
            if(BulkIds[id]){
                console.log("found from update list start removing attribute.");
                console.log(BulkIds[id]);
                delete BulkIds[id]['number'];
                // check only after
            }
        }
        else{
            console.log("number is different from the old.");
            if(!BulkIds[id]){
                console.log('update id not found, create new into update list');
                BulkIds[id]={};
                BulkIds[id]['id'] = id;
            }
            else{

                console.log('update ids already found, set/change the value');
                
            }
            BulkIds[id]['number'] = number;
            
        }

        if(BulkIds[id]['price'] == null){
            price.value = number*OrderBulk[id].price;
        }else{
            price.value = number*BulkIds[id]['price'];
        }
        //Count the property of attribute
        if(CountProperty(BulkIds[id]) < 2){
            console.log("this order has no attribute to update, remove from the list");
            delete BulkIds[id];
        }

        CheckButtonStatus();        
    }



    function ChangeOrderUpdateMenu(id,que=false){
        if(que){
            console.log('que order change menu');
            menu = document.getElementById('update-menu-orderque-'+id).value;
            priceElem = document.getElementById('update-price-orderque-'+id);
            OrderBulk = Orderque; 
            BulkIds = QueUpdateIds; //by ref
        }else{
            console.log('order change menu');
            menu = document.getElementById('update-menu-order-'+id).value;
            priceElem = document.getElementById('update-price-order-'+id);
            OrderBulk = Orders; 
            BulkIds = UpdateIds; //by ref
        }

        if(menu == OrderBulk[id].menu){
            //remove attribute from the array
            console.log("menu is same as old.");
            if(BulkIds[id]){
                console.log("found from update list start removing attribute.");
                delete BulkIds[id]['menu'];
                delete BulkIds[id]['price'];
                priceElem.value = parseFloat(OrderBulk[id].price * OrderBulk[id].number);
                //Count the property of attribute
                if(CountProperty(BulkIds[id]) < 2){
                    console.log("this order has no attribute to update, remove from the list");
                    delete BulkIds[id];
                }
            }
        }
        else{
            console.log("menu is different from the old.");
            if(!BulkIds[id]){
                console.log('update id not found, create new into update list');
                BulkIds[id]={};
                BulkIds[id]['id'] = id;
            }
            else{
                console.log('update ids already found, set/change the value');
            }
            BulkIds[id]['menu'] = menu;
            if(BulkIds[id]['dish_id']){
                key = ''+BulkIds[id]['dish_id']+menu;
            }
            else{
                key = ''+OrderBulk[id]['dish_id']+menu;
            }
            
            if(DishMenuIndexed[key]){
                console.log('dish menu exists: update price');
                console.log(DishMenuIndexed[key]);
                BulkIds[id]['price'] = DishMenuIndexed[key]['price'];
                if(BulkIds[id]['number']){
                    priceElem.value = BulkIds[id]['number']* BulkIds[id]['price'];
                }else{
                    priceElem.value = OrderBulk[id]['number']* BulkIds[id]['price'];
                }
                
            }else{
                
                messages = "{{__('messages.dish_menu_not_exist')}}";
                UIkit.modal.alert(messages);

                priceElem.value = 0;
                BulkIds[id]['price'] = 0;
            }
        }
        console.log(UpdateIds);
        CheckButtonStatus();
    }

    


    function ChangeOrderUpdatePrice(id,que=false){
        if(que){
            console.log('que order update price');
            price = document.getElementById('update-price-orderque-'+id).value;
            OrderBulk = Orderque; 
            BulkIds = QueUpdateIds; //by ref
        }else{
            console.log('order update price');
            price = document.getElementById('update-price-order-'+id).value;
            OrderBulk = Orders; 
            BulkIds = UpdateIds; //by ref
        }

        if(!BulkIds[id]){
            console.log('update id not found, create new into update list');
            BulkIds[id]={};
            BulkIds[id]['id'] = id;
        }
        else{
            console.log('update ids already found, set/change the value');
        }

        if(!BulkIds[id]['number']){
            number = OrderBulk[id]['number'];
        }
        else{
            number = BulkIds[id]['number'];
        }

        BulkIds[id]['price'] = price/number;
        console.log('new price: '+BulkIds[id]['price']);
        console.log('old price: '+OrderBulk[id]['price']);
        if(BulkIds[id]['price'] == OrderBulk[id]['price']){
            console.log('price is same as old, remove from the list');
            delete BulkIds[id]['price'];
            //Count the property of attribute
            if(CountProperty(BulkIds[id]) < 2){
                    console.log("this order has no attribute to update, remove from the list");
                    delete BulkIds[id];
                }
        }
        CheckButtonStatus();

    }
    
    ///////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////
    /////////////////CHECKOUT//////////////////////////////
    ///////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////



    function CashOrderSelected() {
        //post the selected orders
        ids_array = Object.values(ids);
        quearray = Object.values(queids);
        post_body = {};

        post_body['ids'] = ids_array;
        post_body['queids'] = quearray;

        post_body['num_person'] = document.getElementById('checkout_num_person').value;
        console.log(post_body);
        PostCashOrder(post_body);
    }

    function SelectCheckBox(id,que = false){
        if(que){
            console.log('checkbox que order');
            Element = document.getElementById('checkbx-select-que-'+id);
        }else{
            Element = document.getElementById('checkbx-select-'+id);
        }
        Element.checked = true;
        console.log('checked');
        SelectOrder(id,que);
    }
    
    function SelectOrder(id,que = false){
        if(que){
            if(queids[id]){
                return queids[id];
            }
            else{
                number = document.getElementById("number-orderque-"+id).value;
                price = document.getElementById("price-orderque-"+id).value;
                queids[id] ={};
                queids[id]['id'] = id;
                queids[id]['number'] = number;
                queids[id]['price'] =  Orderque[id]['price'];
            }
            console.log(queids);
        }
        else{
            if(ids[id]){
                return ids[id];
            }
            else{
                number = document.getElementById("number-order-"+id).value;
                price = document.getElementById("price-order-"+id).value;
                ids[id] ={};
                ids[id]['id'] = id;
                ids[id]['number'] = number;
                ids[id]['price'] =  Orders[id]['price'];
            }
            console.log(ids);
        }

        
    }

    function ChangeCheckoutNumber(id,que=false){

        if(que){
            if(queids[id]){
                queids[id]['number'] = number;
                delete queids[id]['price'];
            }
            else{
                console.log('queid not found, add to selection.')
                SelectCheckBox(id,que);
                price = Orderque[id]['price'];
                queids[id]['id'] = id;
                queids[id]['number'] = number;
                queids[id]['price'] = price/number;

                document.getElementById("price-orderque-"+id).value = Orderque[id]['price'] *number; 
                document.getElementById("number-info-que-"+id).innerText = Orderque[id]['number'] +' / ' + (Orderque[id]['number'] - number) + ' / ';
            }
        }else{
            
            number = document.getElementById('number-order-'+id).value;

            if(ids[id]){
                ids[id]['number'] = number;
                delete ids[id]['price'];
            }
            else{
                SelectCheckBox(id,que);
                price = Orders[id]['price'];
                ids[id]['id'] = id;
                ids[id]['number'] = number;
                ids[id]['price'] = price/number;
            }
            console.log(document.getElementById("number-info-"+id).innerText);
            document.getElementById("price-order-"+id).value = Orders[id]['price'] *number; 
            document.getElementById("number-info-"+id).innerText = Orders[id]['number'] +' / ' + (Orders[id]['number'] - number) + ' / ';
        }

    }

    function ChangeCheckoutPrice(id,que=false){

        if(que){
            price = document.getElementById('price-orderque-'+id).value;
            number = document.getElementById('number-orderque-'+id).value;
            BulkIds = queids;
            OrderBulk = Orderque;
        }else{
            price = document.getElementById('price-order-'+id).value;
            number = document.getElementById('number-order-'+id).value;
            BulkIds = ids;
            OrderBulk = Orders;
        }

        if(BulkIds[id]){
            BulkIds[id]['number'] = number;
            BulkIds[id]['price'] = price/number;
        }
        else{
            BulkIds[id] ={};
            BulkIds[id]['id'] = id;
            BulkIds[id]['number'] = 1;
            BulkIds[id]['price'] = price/number;
        }
        console.log("new price: "+ ids[id]['price']);

    }

    function CloseCheckoutModal() {
        OrderqueArray = Object.values(Orderque);
        OrdersArray = Object.values(Orders);

        OrderqueArray.forEach(function (element) {
            DeselectOrder(element.id,true);
        });

        OrdersArray.forEach(function (element) {
            DeselectOrder(element.id,false);
        });
        unlockHistory();
    }

    function DeselectOrder(id,que = false){
        if(que){
            idsBulk = queids;
            priceElem = document.getElementById("price-orderque-"+id);
            numberElem = document.getElementById("number-orderque-"+id);
            CheckboxElem = document.getElementById("checkbx-select-que-"+id);
            OrderBulk = Orderque;
        }else{
            idsBulk = ids;
            priceElem = document.getElementById("price-order-"+id);
            numberElem = document.getElementById("number-order-"+id);
            CheckboxElem = document.getElementById("checkbx-select-"+id);
            OrderBulk = Orders;
        }

        numberElem.value = 1;
        if(OrderBulk[id]['price']>0){
            priceElem.value = OrderBulk[id]['price'];
        }
        else{
            priceElem.value = "";
        }
        ChangeCheckoutNumber(id,que);
        delete idsBulk[id];
        CheckboxElem.checked = false;
        console.log('deselected');
        //因为checkbox 自带取消，所以不需要这个
        

    }

    function SwapSelection(id,que = false){
        if(que){
            Element = document.getElementById('checkbx-select-que-'+id);
        }else{
            Element = document.getElementById('checkbx-select-'+id);
        }
        if(Element.checked == true){
            SelectCheckBox(id,que);
        }
        else{
            DeselectOrder(id,que);
        }
    }



    function CashSelect(id) {
        //TODO add/delete into js global variable the current selection/deselection
    }

    var MODIFIABLE_ATTRIBUTES = ['dish_id', 'menu', 'status', 'number', 'que_number'];
    //编辑Order的model和与其的功能
    function EditOrderModal(id) {
        update = 1;
        Orderid = id;
        console.log(Orders);
        //获取order原本的数值
        console.log(id);
        Orderid = search(id, "id", Orders);
        console.log(Orderid);

        //目前只是显示出来而已，之后应当改用为Options(如果餐馆座椅和菜不多的话)
        MODIFIABLE_ATTRIBUTES.forEach(function(attrib, index, arr) {
            document.getElementById("update_" + attrib).value = Orders[Orderid][attrib];
        });
        Orders[id];
        UIkit.modal(document.getElementById("modal-edit_order")).show();

    };


    //POST 编辑
    var OrderUpdateUrl = new String("{{Route('OrderUpdateStaff')}}");
    var update = 0;
    var ready1= 0;
    var ready2= 0;
    function UpdateAddOrder() {
        //进程锁
        if(update){
            console.log("update locked...")
            return;
        }

        ready1 = 1;
        ready2 = 1;
        @php
        //刷新会导致cart内容丢失，所以这里提前发送一次。
        @endphp

        if (getCookie('cart') != "") {
            $.ajax({
                url: "{{ Route('ApiOrderInsertGuest') }}",
                type: "POST",
                data: {
                    "cart": JSON.parse(getCookie('cart')),
                    "code": getCookie('code')
                },
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    console.log(data);
                    setCookie('cart', "", 1);
         
                },
                error: function(data) {
                    setCookie('cart', "", 1);
                    UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:' + data.responseText)
                        .then(function() {
                            console.log(data.responseText)
                            console.log('Alert closed.')
                        });
                },
                timeout: 10000
            });
        }

        var updatebody = {};
        
        if(Object.keys(UpdateIds).length > 0){
            console.log('update ordernow');
            ready1 = 0;
            update = 1;
            updatebody['updatelist'] = Object.values(UpdateIds);
            updatebody['inform_printer'] = 0;
            if(document.getElementById("print_update").checked){
                updatebody['inform_printer'] = 1;
            }
            $.ajax({
                url: OrderUpdateUrl,
                type: "POST",
                data: updatebody,
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    console.log(data);
                    UIkit.modal.alert('Modificato con successo').then(function() {
                        console.log('Alert closed.');
                        update = 0;
                        ready1 = 1;
                        refresh2Ajax();
                    });
                    
                },
                error: function(data) {
                    UIkit.modal.alert('Errore modifica ordini! chieti a assistenza <br>' + 'Error data:' + data
                        .responseText).then(function() {
                        console.log(data.responseText);
                        console.log('Alert closed.');
                        unlockHistory();
                        update = 0;
                        ready1 = 1;
                        refresh2Ajax();
                    });
                    
                    
                },
                timeout: 10000
            });            
        }

        if(Object.keys(QueUpdateIds).length > 0){
            console.log('update orderque');
            ready2 = 0;
            update = 1;
            updatebody['updatelist'] = Object.values(QueUpdateIds);
            console.log(QueUpdateIds);
            $.ajax({
                url: queupdateUrl,
                type: "POST",
                data: updatebody,
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    console.log(data);
                    UIkit.modal.alert('Modificato con successo').then(function() {
                        console.log('Alert closed.')
                        ready2 = 1;
                        update = 0;
                        refresh2Ajax();
                    });
                    
                },
                error: function(data) {
                    UIkit.modal.alert('Errore modifica ordini da stampa. chieti a assistenza <br>' + 'Error data:' + data
                        .responseText).then(function() {
                        console.log(data.responseText)
                        console.log('Alert closed.')
                        ready2 = 1;
                        update = 0;
                        refresh2Ajax();
                    });
                    
                },
                timeout: 10000
            });
        }
    }

    function refresh2Ajax() {
        if(ready1 && ready2){
            window.location.reload();
        }
        
    }

    //确认订单的Modal和POST功能
    function ConfirmOrderModal(id, number, que_number) {
        Orderid = id;
        console.log(id, number, que_number);
        GMax = number - que_number;
        document.getElementById("confirm_num").max = GMax;
        UIkit.modal(document.getElementById("modal-confirm_order")).show();

    };

    function DeleteConfirm(id) {
        UIkit.modal.confirm("@lang('messages.DeleteOrderConfirm')" + id).then(function() {
            console.log('Confirmed.');
            AjaxDeleteOrder(id);
        }, function() {
            console.log('Rejected.')
        });
    }


    function AjaxDeleteOrder(id) {
        $.ajax({
            url: "{{Route('OrderDelete')}}",
            type: "POST",
            data: {
                "id": id,
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                console.log(data);
                UIkit.modal.alert('Cancellato con successo').then(function() {
                    console.log('Alert closed.')
                    window.location.reload();
                });
            },
            error: function(data) {
                UIkit.modal.alert('Errore! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            },
            timeout: 10000
        });
    }

    function ConfirmOrder(all = 0) {
        if (all == 0) {
            console.log('normal confirm');
            que_number = document.getElementById("confirm_num").value;
        } else {
            console.log('max confirm');
            que_number = GMax;
        }

        console.log(que_number);
        $.ajax({
            url: "{{Route('OrderConfirmStaff')}}",
            type: "POST",
            data: {
                "id": Orderid,
                "que_number": que_number,
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                console.log(data);
                UIkit.modal.alert('Confermato con successo').then(function() {
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

    //activate 和deactivate 手动调整价格
    function TogglePrezzo() {
        element = document.getElementById("order_price");

        element.disabled = !element.disabled;
        if (element.disabled == true) {
            element.placeholder = 'calcolo automatico';
        } else {
            element.placeholder = 'inserire un prezzo';
        }
    }

    //数一个【字典】的属性数量。
    function CountProperty(object){
        var count = 0;
        for (var k in object) {
            if (object.hasOwnProperty(k)) {
               ++count;
            }
        }
        return count;
    }

    function ClearDish(id,que=false) {
        if(que){
            input_target = "#update-dish-orderque-"+id;
        }
        else{
            input_target = "#update-dish-order-"+id;
        }
        $(input_target).flexdatalist('value','');

    }
</script>