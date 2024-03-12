<div class="uk-card uk-card-default">
    <div class="uk-overflow-auto uk-card-body">
        <a class="uk-button uk-button-primary uk-button-small" onclick="PrintNow()"><i uk-icon="print"></i> Stampa
            subito</a>
        <div class="uk-margin-bottom uk-hidden@m"></div>
        <p>Prossima stampa nel: {{ \Carbon\Carbon::parse($ordersque['table_history'][0]['next_checkmerge']) }}</a>
        <table class="uk-table uk-table-striped uk-table-small uk-table-hover">
            <thead>
                <tr>
                    <th class="uk-table-shrink">Prezzo(€)</th>
                    <th class="uk-table-shrink">@lang('messages.number')</th>
                    <th>@lang('messages.dish')</th><!-- class="uk-table-shrink" -->
                    <th class="uk-table-shrink">@lang('messages.menu')</th>
                    <th class="uk-table-shrink">@lang('messages.order_at')</th>
                </tr>
            </thead>
            <tbody>
                @isset($ordersque['table_history'][0])
                    @foreach ($ordersque['table_history'][0]['orderque'] as $order)
                        <tr>
                            <td>@if ($order['price'] != '0.00'){{ $order['price'] * $order['number'] }}@endif</td>
                            <td>{{ $order['number'] }}</td>
                            <td>{{ $order['dish']['name'] }}</td>
                            <td>{{ $menus[$order['menu']]['name'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($order['order_at'])->format('H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            @endisset
        </table>
    </div>
</div>
<!-- This is the modal for editing the orderQue-->
<div id="modal-edit_orderque" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Modifica Ordine Pre Stampa</h2>
        </div>
        <div class="uk-modal-body">
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Quantita'</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="updateque_number" type="number" min='0'
                            placeholder="insert a number..." value="1">
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Piatto</label>
                    </div>
                    <div class="uk-form-controls uk-width-5-6">
                        <select class="uk-select" id="updateque_dish_id">
                            @foreach ($dishes as $dish)
                                <option value={{ $dish['id'] }}>{{ $dish['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                    <div class="uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Menu</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <select class="uk-select" id="updateque_menu">
                            @foreach ($menus as $menu)
                                <option value={{ $menu['id'] }}>{{ $menu['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="uk-margin-small">
                <label><input class="uk-checkbox" type="checkbox" id="manual_priceque" onclick="TogglePrezzoQue()">
                    Assegna prezzo unitario manualmente</label>
            </div>
            <div>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid="">
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="priceLabel">Prezzo Unitario</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-3">
                        <input class="uk-input uk-form-width-large" id="orderque_price" type="number" min='0' step=".01"
                            placeholder="calcolo automatico" disabled>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close uk-button-small" type="button">Cancella</button>
            <button class="uk-button uk-button-primary uk-button-small" type="button"
                onclick="UpdateAddOrderQue()">Modifica</button>
        </div>
    </div>
</div>
<script>
    var MODIFIABLE_ATTRIBUTES_ORDERQUE = ['dish_id', 'menu', 'number'];
    //GLOBAL VARIABLE:
    //Orderid
    //update
    var updateQue = 1;
    var queupdateUrl = new String("{{Route('OrderQueUpdateStaff')}}");
    var Orderque_id = 0
    var Orderque = @json($ordersque).table_history[0].orderque;
    function EditOrderQueModal(id) {
        updateQue = 1;
        Orderque_id = id;
        console.log(id);
        Orderque_id = search(id, "id", Orderque);
        //目前只是显示出来而已，之后应当改用为Options(如果餐馆座椅和菜不多的话)
        MODIFIABLE_ATTRIBUTES_ORDERQUE.forEach(function(attrib, index, arr) {
            document.getElementById("updateque_" + attrib).value = Orderque[Orderid][attrib];
        });
        lockHistory();
        UIkit.modal(document.getElementById("modal-edit_orderque")).show();
    };

    //POST 编辑

    function UpdateAddOrderQue() {

        var updatebody = {};
        updatebody['updatelist'] = QueUpdateIds;
        //updatebody['table_history_id'] = table_history['id'];
        console.log('update mode...');
        console.log(queupdateUrl);
        //检查是否有什么改变
        if (Object.keys(updatebody).length > 0) {

            updatebody['id'] = Orderque[Orderque_id].id;

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
                        window.location.reload();
                    });
                },
                error: function(data) {
                    UIkit.modal.alert('Errore modifica ordini da stampa. chieti a assistenza <br>' + 'Error data:' + data
                        .responseText).then(function() {
                        console.log(data.responseText)
                        console.log('Alert closed.')
                    });
                },
                timeout: 10000
            });
        }
    }

    function DeleteConfirmOrderQue(id) {
        UIkit.modal.confirm("@lang('messages.DeleteOrderConfirm')" + id).then(function() {
            console.log('Confirmed.');
            AjaxDeleteOrderque(id);
        }, function() {
            console.log('Rejected.')
        });
    }


    function AjaxDeleteOrderque(id) {
        $.ajax({
            url: "{{ Route('OrderQueDelete') }}",
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
                UIkit.modal.alert('Errore! chieti a assistenza <br>' + 'Error data:' + data.responseText)
                    .then(function() {
                        console.log(data.responseText)
                        console.log('Alert closed.')
                    });
            },
            timeout: 10000
        });
    }

    //activate 和deactivate 手动调整价格
    function TogglePrezzoQue() {
        element = document.getElementById("orderque_price");

        element.disabled = !element.disabled;
        if (element.disabled == true) {
            element.placeholder = 'calcolo automatico';
        } else {
            element.placeholder = 'inserire un prezzo';
        }
    }
</script>
