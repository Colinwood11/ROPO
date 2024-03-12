@extends('admin.template')
@section('content')


<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">

            <h3>Order List</h3>
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome Piatto </th>
                        <th class="uk-table-shrink">Numero Tavolo</th>
                        <th class="uk-table-shrink">Quantita'</th>
                        <th>Menu</th>
                        <th class="uk-table-shrink">Ordinato a</th>
                        <th>Stato</th>
                        <th>Prezzo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order['id']}}</td>
                        <td>{{$order['dish']['name']}}</td>
                        <td>
                            @if(isset($order['table_history']['table']))
                            {{$order['table_history']['table']['number']}}
                            @else
                            No Tavolo
                            @endif
                        </td>
                        <td>{{$order['que_number']}} / {{$order['number']}}</td>
                        <td>
                            @php
                            $res = array_values(array_filter($menus,function($item) use($order)
                            {
                            return $item['id'] == $order['menu'];
                            }));
                            if(isset($res[0]))
                            {
                            echo($res[0]['name']);
                            }
                            else
                            {
                            echo('Null');
                            }

                            @endphp
                        </td>

                        <td>{{\Carbon\Carbon::parse($order['order_at'])->format('H:i')}}</td>
                        <td>{{$order['status']}}</td>
                        <td style="float: right;">
                            @if($order['status'] != 'confirmed')
                            <a class="uk-button uk-button-primary" onclick="ConfirmOrderModal({{$order['id']}},{{$order['number']}},{{$order['que_number']}})" uk-icon="check"></a>
                            @endif
                            <a class="uk-button uk-button-primary" onclick="EditOrderModal({{$order['id']}})" uk-icon="pencil"></a>
                            <a class="uk-button uk-button-primary" onclick="DeleteConfirm({{$order['id']}})" uk-icon="trash"></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- This is the modal for editing the order-->
<div id="modal-edit_order" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Modifica Ordine</h2>
        </div>
        <div class="uk-modal-body">
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Quantita'</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="update_number" type="number" min='0' placeholder="insert a number..." value="1">
                    </div>
                    <div class="uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Quantita' confermata</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="update_que_number" type="number" min='0' placeholder="insert a number..." value="1">
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Piatto</label>
                    </div>
                    <div class="uk-form-controls uk-width-5-6">
                        <input class="uk-input uk-form-width-large" id="update_dish_id" type="text" min='0' placeholder="insert a dish" value="1">
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Tavolo D'Ordine</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="update_table_history_id" type="number" min='0' placeholder="insert a number..." value="1">
                    </div>
                    <div class="uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Menu</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="update_menu" type="number" min='0' placeholder="insert a number..." value="1">
                    </div>
                </div>
            </div>
            <div class="uk-margin-small">
                <label><input class="uk-checkbox" type="checkbox" id="auto_price" onclick="TogglePrezzo()"> Assegna prezzo manualmente</label>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid="">
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="priceLabel">Prezzo</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="order_price" type="number" min='0' step=".01" placeholder="calcolo automatico" disabled>
                    </div>
                    <div class="uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Stato</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="update_status" type="text" min='0' placeholder="insert a number..." value="1">
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancella</button>
            <button class="uk-button uk-button-primary" type="button" onclick="UpdateOrder()">Modifica</button>
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
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancella</button>
            <button class="uk-button uk-button-primary" type="button" onclick="ConfirmOrder()">Conferma</button>
            <button class="uk-button uk-button-primary" type="button" onclick="ConfirmOrder(1)">Conferma Tutto</button>
        </div>
    </div>
</div>



<hr class="uk-divider-icon uk-margin-medium">
<!--@lang('messages.description')-->
<script>

    var MODIFIEDBLE_ATTRIBUTES = ['dish_id','table_history_id','menu','status','number','que_number'];

    //由于是管理员内部使用，可以冒着数据泄露的风险parse所有数据（除非自己泄露我自己）
    var Orders = {!!json_encode($orders,JSON_HEX_TAG)!!};
    var Dishes = {!!json_encode($dishes,JSON_HEX_TAG)!!};
    var Menu = {!!json_encode($menus,JSON_HEX_TAG)!!};
    var History = {!!json_encode($histories,JSON_HEX_TAG)!!};

    var Orderid = 0;
    var GMax = 0;    
    //编辑Order的model和与其的功能
    function EditOrderModal(id) {
        Orderid = id;
        //获取order原本的数值
        console.log(Orders[id]);
        
        //目前只是显示出来而已，之后应当改用为Options(如果餐馆座椅和菜不多的话)
        MODIFIEDBLE_ATTRIBUTES.forEach(function(attrib, index, arr)
        {
            document.getElementById("update_"+attrib).value = Orders[id][attrib];            
        });
        //document.getElementById("update_number").value = Orders[id]['number'];
        //document.getElementById("update_que_number").value = Orders[id]['que_number'];
        //document.getElementById("update_dish_id").value = Orders[id]['dish_id'];
        //document.getElementById("update_table_history_id").value = Orders[id]['table_history_id'];
        //document.getElementById("update_menu").value = Orders[id]['menu'];
        //document.getElementById("update_status").value = Orders[id]['status'];
        
        Orders[id];
        UIkit.modal(document.getElementById("modal-edit_order")).show();

    };

    //POST 编辑
    function UpdateOrder() {
        
        var updatebody = {};
        MODIFIEDBLE_ATTRIBUTES.forEach(function(attrib, index, arr)
        {
            var form_value = document.getElementById("update_"+attrib).value;
            //不需要修改
            if(form_value != Orders[Orderid][attrib])
            {
                updatebody[attrib] = form_value;
            }
            //document.getElementById("update_number").value = Orders[id]['number'];
            
        });

        //检查是否有什么改变
        if(Object.keys(updatebody).length>0)
        {
            
            
            updatebody['id'] = Orderid;
            console.log(updatebody);
            
            $.ajax({
                url: "{{Route('OrderUpdateStaff')}}",
                type: "POST",
                data: updatebody,
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    console.log(data);
                    UIkit.modal.alert('Modificato con successo').then(function() {
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

        
    }

    //确认订单的Modal和POST功能
    function ConfirmOrderModal(id, number, que_number) {
        Orderid = id;
        console.log(id, number, que_number);
        GMax = number - que_number;

        document.getElementById("confirm_num").max = GMax;
        UIkit.modal(document.getElementById("modal-confirm_order")).show();

    };

    function DeleteConfirm(id)
    {
        UIkit.modal.confirm("@lang('messages.DeleteOrderConfirm')"+id).then(function() {
            console.log('Confirmed.');
            AjaxDeleteOrder(id);
        }, function() {
            console.log('Rejected.')
        });
    }
    

    function AjaxDeleteOrder(id)
    {
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

    //不痛不痒的小功能，一些activate 和deactivate
    function TogglePrezzo() {
        element = document.getElementById("order_price");
        
        element.disabled = !element.disabled;
        if(element.disabled == true)
        {
            element.placeholder = 'calcolo automatico';
        }
        else
        {
            element.placeholder = 'inserire un prezzo';
        }
    }
</script>
@stop