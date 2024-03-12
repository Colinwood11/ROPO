@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">
        <div class="uk-grid-margin uk-first-column">
            <h3>
                Lista：<div id="tittle1_number"></div>
                <span style="float:right;">
                    <a class="uk-button uk-button-primary uk-button-small" uk-toggle="target: #table-id"><i uk-icon="list"></i> Lista</a>
                    <a class="uk-button uk-button-primary uk-button-small" onclick="SendOrder();"><i uk-icon="print"></i> Send</a>
                </span>
            </h3>
            <table id="table-id" class="uk-table uk-table-striped uk-table-hover" hidden>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Menu</th>
                        <th class="uk-preserve-width">Azione</th>
                    </tr>
                </thead>
                <tbody id="tbody-id">
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<div class="uk-card uk-card-default">
    <div class="uk-card-body">
        <div class="uk-grid-margin uk-first-column">
            <h3>Aggiunge piato
                <span style="float:right;">
                    <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                        <div class="uk-width-1-6">
                            <label class="uk-form-label" for="form-h-text">Menu</label>
                        </div>
                        <div class="uk-form-controls uk-width-1-1">
                            <select class="uk-select" id="update_menu">
                                @foreach($menus as $menu)
                                <option value={{$menu['id']}}>{{$menu['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </span>
            </h3>
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numero</th>
                        <th>Nome</th>
                        <th class="uk-preserve-width">Azione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dishes as $dish)
                    <tr>
                        <td>{{$dish['id']}}</td>
                        <td>{{$dish['number_code']}}</td>
                        <td>{{$dish['name']}}</td>
                        <td class="uk-preserve-width">
                            <a class="uk-button uk-button-primary" onclick="Additem({{$dish['id']}}, '{{$dish['name']}}')"><i uk-icon="plus-circle"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", function() {
        setCookie('cart', "", 1);


    });

    var tid = 0;
    var Dishes = @json($dishes);

    function SendOrder() {
        console.log(getCookie('cart'));
        if (getCookie('cart') != "") {
            $.ajax({
                url: "{{Route('ApiOrderInsertGuest')}}",
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
                    UIkit.modal.alert('OK！').then(function() {
                        console.log('Alert closed.')
                    });
                },
                error: function(data) {
                    setCookie('cart', "", 1);
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
            });
        }
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
@stop