<!DOCTYPE html>
<html>
@include('admin.include.header')

<body>
    <!-- MOBI Nav -->
    @include('admin.include.mobinavbar')
    <!-- sidebar -->
    <div class="uk-background-primary uk-light uk-visible@s sidebar">
        <h3><a href="" class="uk-navbar-item uk-logo"><img uk-svg="" src="" class="uk-margin-small-right"
                    hidden="true"><svg width="28" height="34" viewBox="0 0 28 34" xmlns="http://www.w3.org/2000/svg"
                    class="uk-margin-small-right uk-svg" data-svg="">
                    <polygon fill="#fff" points="19.1,4.1 13.75,1 8.17,4.45 13.6,7.44 "></polygon>
                    <path fill="#fff"
                        d="M21.67,5.43l-5.53,3.34l6.26,3.63v9.52l-8.44,4.76L5.6,21.93v-7.38L0,11.7v13.51l13.75,8.08L28,25.21V9.07 L21.67,5.43z">
                    </path>
                </svg> UIkit</a></h3>
        <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
            <li>
                <a href="{{route('TableList')}}"><span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>
                    Tavoli
                </a>
            </li>

            <div class="uk-grid-margin uk-first-column">
                <h3>Tavolo：{{$orders['number']}}
                </h3>
                @isset($orders['table_history'][0])
                Numero persone: {{$orders['table_history'][0]['num_person']}}
                <br>
                @endisset
                Prezzo extra: {{$orders['order_allprice']+$ordersque['order_allprice']}} €
                <br>
                Menu: @foreach($orders['menus'] as $menu)
                @if($menu['fixed_price'] !=0)
                @isset($orders['table_history'][0])
                <br>
                {{$menu['name']}}: {{$orders['table_history'][0]['num_person']}} x
                {{$menu['fixed_price']}}€
                @endisset
                @endif
                @endforeach
                <br><br>
                Totale: {{$orders['order_allprice']+ $ordersque['order_allprice'] +
                $orders['menu_allprice']}} €
                <br>
            </div>

            <li class="uk-nav-divider"></li>
            <li class="uk-nav-header">
                <a href="#">Conto</a>
            </li>

            <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small"
                onclick="CashOrderConfirm()">
                <i uk-icon="pencil"></i> Totale
            </a>

            <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small"
                onclick="PartialCheckOutModal()">
                <i uk-icon="close"></i> Parziale
            </a>

            <li class="uk-nav-divider"></li>

            <li class="uk-nav-header">
                <a href="#">Azione</a>
            </li>

            <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small"
                onclick="TableHistoryEditModal()">
                <i uk-icon="pencil"></i> Cambia persone
            </a>

            <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small"
                onclick="CloseTableConfirm()">
                <i uk-icon="close"></i> Chiude Tavolo
            </a>

            <a class="uk-button uk-button-default uk-width-1-1 uk-margin-top uk-button-small" onclick="SendOrder()">
                <i uk-icon="print"></i> Send
            </a>
        </ul>

    </div>
    <!-- main -->
    <div class="uk-container uk-container-expand uk-background-muted main">
        <div class="uk-section uk-section-xsmall uk-padding-remove-top">
            @include('admin.include.navbar')
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
                <li class="uk-active">
                    <a href="#" aria-expanded="true" id='aggiunge'><i uk-icon="plus"></i> Aggiunge</a>
                </li>
                <li class="">
                    <a href="#" aria-expanded="false" id='carrello'>
                        <i uk-icon="cart"></i> Carrello
                    </a>
                </li>
                <li class="">
                    <a href="#" aria-expanded="false" id='specifico'><i uk-icon="list"></i> Specifico</a>
                </li>
                <li class="">
                    <a href="#" aria-expanded="false" id='wait'>In attesa stampa</a>
                </li>
            </ul>

            <ul class="uk-switcher" style="touch-action: pan-y pinch-zoom;" id="main-switch">
                <!-- Aggiunge(dish menu) -->
                <li class="uk-active">
                    @include('admin.TableOrders.AddDish')
                </li>
                <!-- Carrello -->
                <li>
                    @include('admin.TableOrders.Cart')
                </li>
                <!-- Specifico -->
                <li>
                    @include('admin.TableOrders.Specifico')
                </li>
                <!--In attesa stampa (OrderQue)-->
                <li>
                    @include('admin.TableOrders.OrderQue')
                </li>
            </ul>

            <!-- This is the modal for editing the table-->
            <div id="modal-edit-tablehistory" uk-modal>
                <div class="uk-modal-dialog uk-margin-auto-vertical">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <div class="uk-modal-header">
                        <h2 class="uk-modal-title">Modifica Tavolo Corrente</h2>
                    </div>
                    <div class="uk-modal-body">
                        <div>
                            <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                                <div class="uk-first-column uk-width-1-6">
                                    <label class="uk-form-label" for="form-h-text">Numero di persone</label>
                                </div>
                                <div class="uk-form-controls uk-width-1-3">
                                    <input class="uk-input uk-form-width-large" id="table_history_person" type="number"
                                        min='0' placeholder="insert a number..." value="1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-modal-footer uk-text-right">
                        <button class="uk-button uk-button-default uk-modal-close uk-button-small"
                            type="button">Cancella</button>
                        <button class="uk-button uk-button-primary uk-button-small" type="button"
                            onclick="TableHistoryUpdate()">Modifica</button>
                    </div>
                </div>
            </div>

            <script>
                window.addEventListener("load", function() {
                    setCookie('cart', "", 1);
                    setCookie('code', "{{$orders['code']}}", 1);
            
                    if (checkAuditTime("11:00", "15:00")) {
                        document.getElementById("admin_menu").options[2].selected = true;
                    } else if (checkAuditTime("18:00", "24:00")) {
                        document.getElementById("admin_menu").options[1].selected = true;
                    }
            
                    @php
                    /*默认获取的menu*/
                    @endphp
                    InitMenu();
            
                    @php
                    /*需要一个数组用来快速查找O(1)*/
                    @endphp
                    getAllDish();
            
                    @php
                    /*O(1)Order查询订单的数组*/
                    @endphp
                    OrdersIndex();
            
                    @php
                    /*O(1)Order查询打印列表的数组*/
                    @endphp
                    OrderQueIndex();
            
                    @php
                    /*获取DishMenu*/
                    @endphp
                    GetDishMenu();
            
                });
            
                var ids = [];
                //由于是管理员内部使用，可以冒着数据泄露的风险parse所有数据（除非自己泄露我自己）
                var History = @json($histories);
                var table_history = @json($orders['table_history'][0]);
                var Table = @json($histories)[0].table;
                //GLOBAL VARIABLE
                var GMax = 0;
                var post
            
                function GoElement() {
                    document.getElementById("number100").scrollIntoView();
                }
            
                function lockHistory() {
                    id = table_history.id;
                    console.log("locking table");
                    $.ajax({
                        url: "{{Route('ApiLockHistory')}}",
                        type: "POST",
                        data: {
                            "id": id
                        },
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {},
                        error: function(data) {
                            UIkit.modal.alert('lock history failed <br>' + 'Error data:' + data
                                .responseText).then(function() {
                                console.log(data.responseText)
                                console.log('Alert closed.')
                            });
                        },
                        timeout: 10000
                    });
                }
            
                function unlockHistory() {
                    id = table_history.id;
                    console.log("unlocking table");
                    $.ajax({
                        url: "{{Route('ApiUnlockHistory')}}",
                        type: "POST",
                        data: {
                            "id": id
                        },
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {},
                        error: function(data) {
                            UIkit.modal.alert('unlock history failed <br>' + 'Error data:' + data
                                .responseText).then(function() {
                                console.log(data.responseText)
                                console.log('Alert closed.')
                            });
                        },
                        timeout: 10000
                    });
                }
            
                function PrintNow() {
                    $.ajax({
                        url: "{{Route('ApiMergeTableHistory',$orders['number'])}}",
                        type: "GET",
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {
                            console.log(data);
                            UIkit.modal.alert('Inserito nella coda di stampa con successo').then(function() {
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
            
                //编辑TableHistory的modal
                function TableHistoryEditModal() {
                    document.getElementById("table_history_person").value = table_history.num_person;
                    UIkit.modal(document.getElementById("modal-edit-tablehistory")).show();
                };
            
                function TableHistoryUpdate() {
                    post_body = {};
                    post_body['num_person'] = document.getElementById("table_history_person").value;
                    post_body['id'] = table_history.id;
                    PostTableHistory(post_body);
                };
            
                function PostTableHistory(post_body) {
                    $.ajax({
                        url: "{{Route('ApiTableHistoryUpdate')}}",
                        type: "POST",
                        data: post_body,
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
                            UIkit.modal.alert('Errore! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                                console.log(data.responseText)
                                console.log('Alert closed.')
                            });
                        },
                        timeout: 10000
                    });
                }
            
                function CashOrderConfirm() {
                    modal = UIkit.modal.confirm("@lang('messages.CashOrderConfirm')")
                    elment = modal.dialog
                    button_confirm = elment.$el.childNodes[1].childNodes[0].childNodes[3].childNodes[3];
                    button_cancel = elment.$el.childNodes[1].childNodes[0].childNodes[3].childNodes[1];
                    button_confirm.classList.add('uk-button-primary')
                    button_cancel.classList.add('uk-button-default')
                    modal.then(function() {
                        console.log('Confirmed.');
                        CashOrderAll();
                    }, function() {
                        console.log('Rejected.')
                    });
                }
            
                function CashOrderAll() {
                    post_body = {};
                    post_body['ids'] = [];
                    post_body['queids'] = [];
                    OrdersArray = Object.values(Orders);
                    OrdersArray.forEach(function(order, index, arr) {
                        newOrder = {};
                        newOrder['id'] = order.id;
                        post_body['ids'].push(newOrder);
                    });
                    OrderQueArray = Object.values(Orderque);
                    OrderQueArray.forEach(function(orderque, index, arr) {
                        newOrderQue = {};
                        newOrderQue['id'] = orderque.id;
                        post_body['queids'].push(newOrderQue);
                    });
                    post_body['num_person'] = table_history['num_person'];
                    console.log(post_body);
                    PostCashOrder(post_body);
                }
            
            
                function PostCashOrder(post_body) {
                    $.ajax({
                        url: "{{Route('ApiCashOrder')}}",
                        type: "POST",
                        data: post_body,
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {
                            console.log(data);
                            UIkit.modal.alert('Fatturato con successo').then(function() {
                                console.log('Alert closed.')
                                //成功的情况下由PHP解锁
                                //unlockHistory();
            
                                window.location.replace("{{url('admin/invoice')}}" + "/" + data.id);
                            });
                        },
                        error: function(data) {
                            UIkit.modal.alert('Errore! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                                console.log(data.responseText)
                                console.log('Alert closed.');
                                unlockHistory();
                            });
                        },
                        timeout: 10000
                    });
                }
            
                function CloseTableConfirm() {
                    modal = UIkit.modal.confirm("@lang('messages.CloseTableConfirm')")
                    elment = modal.dialog
                    button_confirm = elment.$el.childNodes[1].childNodes[0].childNodes[3].childNodes[3];
                    button_cancel = elment.$el.childNodes[1].childNodes[0].childNodes[3].childNodes[1];
                    button_confirm.classList.add('uk-button-danger')
                    button_cancel.classList.add('uk-button-primary')
                    modal.then(function() {
                        console.log('Confirmed.');
                        CloseTable();
                    }, function() {
                        console.log('Rejected.')
                    });
                }
            
                function CloseTable() {
                    $.ajax({
                        url: "{{Route('TableDeactivate')}}",
                        type: "POST",
                        data: {
                            "id": table_history.table_id,
                        },
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {
                            console.log(data);
                            UIkit.modal.alert('Confermato con successo').then(function() {
                                console.log('Alert closed.')
                                window.location.replace("{{route('TableList')}}");
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
            
                function search(value, attribute, myArray) {
                    for (var i = 0; i < myArray.length; i++) {
                        console.log(myArray[i][attribute]);
                        if (myArray[i][attribute] === value) {
                            return i;
                        }
                    }
                    console.log('not found');
                }
            
                function checkAuditTime(beginTime, endTime) {
                    var nowDate = new Date(),
                        beginDate = new Date(nowDate),
                        endDate = new Date(nowDate);
            
                    var beginIndex = beginTime.lastIndexOf("\:");
                    var beginHour = beginTime.substring(0, beginIndex);
                    var beginMinue = beginTime.substring(beginIndex + 1, beginTime.length);
                    beginDate.setHours(beginHour, beginMinue, 0, 0);
            
                    var endIndex = endTime.lastIndexOf("\:");
                    var endHour = endTime.substring(0, endIndex);
                    var endMinue = endTime.substring(endIndex + 1, endTime.length);
                    endDate.setHours(endHour, endMinue, 0, 0);
                    if (nowDate.getTime() - beginDate.getTime() >= 0 && nowDate.getTime() <= endDate.getTime()) {
                        return true;
                    } else {
                        return false;
                    }
                }
            </script>
        </div>
    </div>

    <!-- m-nav -->
    <div id="m-nav" uk-offcanvas="overlay: true">
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
                <li class="uk-active">
                    <a href="{{route('TableList')}}">
                        <span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span>
                        Tavoli
                    </a>
                </li>
                <div class="uk-grid-margin uk-first-column">
                    <h3>Tavolo：{{$orders['number']}}
                    </h3>
                    @isset($orders['table_history'][0])
                    Numero persone: {{$orders['table_history'][0]['num_person']}}
                    <br>
                    @endisset
                    Prezzo extra: {{$orders['order_allprice']+$ordersque['order_allprice']}} €
                    <br>
                    Menu: @foreach($orders['menus'] as $menu)
                    @if($menu['fixed_price'] !=0)
                    @isset($orders['table_history'][0])
                    <br>
                    {{$menu['name']}}: {{$orders['table_history'][0]['num_person']}} x
                    {{$menu['fixed_price']}}€
                    @endisset
                    @endif
                    @endforeach
                    <br><br>
                    Totale: {{$orders['order_allprice']+ $ordersque['order_allprice'] +
                    $orders['menu_allprice']}} €
                    <br>
                </div>
                <hr>
            </ul>

            <a class="uk-button uk-button-default" onclick="TableHistoryEditModal()">
                <i uk-icon="pencil"></i> Cambia persone
            </a>

            <br><br>

            <a class="uk-button uk-button-default" onclick="CloseTableConfirm()">
                <i uk-icon="close"></i> Chiude Tavolo
            </a>

            <br><br>

            <a class="uk-button uk-button-default" onclick="SendOrder()">
                <i uk-icon="print"></i> Send
            </a>

        </div>
    </div>


</body>
@include('admin.include.footer')

</html>