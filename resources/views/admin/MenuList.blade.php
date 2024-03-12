@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">
            <h3>Menu
                <span style="float:right;">
                    <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal()">Crea Nuovi Menù</a>
                </span>
            </h3>
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Weight</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr>
                        <td>{{$menu['id']}}</td>
                        <td>{{$menu['name']}}</td>
                        <td>{{$menu['status']}}</td>
                        <td>{{$menu['weight']}}</td>
                        <td>
                            <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal({{$menu['id']}})"></a>
                            <a class="uk-button uk-button-primary" uk-icon="trash" onclick="confirm_delete({{$menu['id']}})"></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- This is the categoria-principale modal for insert/modify -->
<div id="modal-menu" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Menu</h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Nome</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="menu_name" type="text" placeholder="inserisci il testo...">
                </div>
                <label class="uk-form-label" for="form-h-text">Peso</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="menu_weight" type="number" min="0" placeholder="insericsi un numero..">
                </div>
                <label class="uk-form-label" for="form-h-text">Orario</label>
                <div class="uk-margin-small uk-grid-small uk-grid" uk-grid="">
                    <div class="uk-first-column uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text" id="priceLabel">Inizio</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-4">
                        <input class="uk-input uk-form-width-large" id="start_time" type="time" min="0" step="1" placeholder="insericsi un numero..">
                    </div>
                    <div class="uk-width-1-6">
                        <label class="uk-form-label" for="form-h-text">Fine</label>
                    </div>
                    <div class="uk-form-controls uk-width-1-4">
                        <input class="uk-input uk-form-width-large" id="end_time" type="time" min="0" step="1" placeholder="insericsi un numero..">
                    </div>
                </div>
                <label class="uk-form-label" for="form-h-text">Prezzo</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="fixed_price" type="number" min="0" placeholder="insericsi un numero..">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" id="modal_confirm_button" type="button" onclick="post_menuUpdate()">Save</button>
        </div>
    </div>
</div>

<script>
    var menus = @json($menus);
    var cid = 0;
    var catname = '';
    var cattype = 0;
    var action = 0;
    console.log(menus);
    /*
     * cid        cat或者sottocat的ID  为0则新建
     * catname      编辑时传入的名字   用于显示在编辑框中
     * cattype   0：主Cat  1:子Cat
     * action    0：新增  1：编辑  2：删除
     */

    function show_modal(id1) {
        if(id1 != undefined)
        {
            cid = id1;
            menu = menus[id1];
            console.log(menu);
            document.getElementById("menu_name").value = menu.name;
            document.getElementById("menu_weight").value = menu.weight;
            document.getElementById("start_time").value = menu.start_time;
            document.getElementById("end_time").value = menu.end_time;
            document.getElementById("fixed_price").value = menu.fixed_price;
            document.getElementById('modal_confirm_button').setAttribute('onclick','post_menuUpdate()')
        }
        else
        {
            document.getElementById('modal_confirm_button').setAttribute('onclick','post_MenuInsert()')
        }
        
        UIkit.modal(document.getElementById("modal-menu")).show();

    }

    function post_menuUpdate()
    {
        postbody = {};
        postbody.id = cid;
        postbody.name = document.getElementById("menu_name").value
        postbody.weight = document.getElementById("menu_weight").value
        postbody.start_time = document.getElementById("start_time").value 
        postbody.end_time = document.getElementById("end_time").value
        postbody.fixed_price = document.getElementById("fixed_price").value

        $.ajax({
            url: "{{Route('MenuUpdate')}}",
            type: "POST",
            data: postbody,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                UIkit.modal.alert("OK").then(function() {
                    window.location.reload();
                    console.log(data.responseText)
                    console.log('Alert closed.')
                })
                
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

    function post_MenuInsert()
    {
        postbody = {};
        postbody.name = document.getElementById("menu_name").value
        postbody.weight = document.getElementById("menu_weight").value
        postbody.start_time = document.getElementById("start_time").value 
        postbody.end_time = document.getElementById("end_time").value
        postbody.fixed_price = document.getElementById("fixed_price").value

        $.ajax({
            url: "{{Route('MenuInsert')}}",
            type: "POST",
            data: postbody,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                UIkit.modal.alert("OK").then(function() {
                    window.location.reload();
                    console.log(data.responseText)
                    console.log('Alert closed.')
                })
                
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

    function confirm_delete($id){
        UIkit.modal.confirm('Sei siccuro a cancellare ' + menus[$id].name + "?").then(function() {
            $.ajax({
                url: "{{Route('MenuDelete')}}",
                type: "POST",
                data: {
                    "id": $id
                },
                dataType: "JSON",
                sync: 'true',
                success: function(data) {
                    UIkit.modal.alert("OK").then(function() {
                        window.location.reload();
                        console.log(data.responseText)
                        console.log('Alert closed.')
                    })
                    
                },
                error: function(data) {
                    UIkit.modal.alert('Error! chieti a assistenza <br>' + 'Error data:' + data.responseText).then(function() {
                        console.log(data.responseText)
                        console.log('Alert closed.')
                    });
                },
                timeout: 10000
            });
        });
    }

    function post_categoria() {
        switch (action) {
            /* 新增 */
            case 0:
                /*   cattype   0：主Cat  1:子Cat */
                if (cattype == 0) {
                    url = '{{url("api/category/insert")}}';
                    data = {
                        "Catname": document.getElementById("catname").value,
                        "weight":document.getElementById("category_weight").value
                    }
                } else {
                    url = '{{url("api/subcategory/insert")}}';
                    data = {
                        "name": document.getElementById("sottocatname").value,
                        "Category_id": document.getElementById("form-h-select").value,
                        "weight":document.getElementById("subcategory_weight").value
                    }
                }
                break;
                /* 修改 */
            case 1:
                /*   cattype   0：主Cat  1:子Cat */
                if (cattype == 0) {
                    url = '{{url("api/category/update")}}';
                    data = {
                        "id": cid,
                        "Catname": document.getElementById("catname").value,
                        "weight":document.getElementById("category_weight").value
                    };
                } else {
                    url = '{{url("api/subcategory/update")}}';
                    data = {
                        "id": cid,
                        "name": document.getElementById("sottocatname").value,
                        "Category_id": document.getElementById("form-h-select").value,
                        "weight": document.getElementById("subcategory_weight").value
                    }
                }
                break;
            default:
                console.log(`Sorry, we are out of ${action}.`);
        }

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                window.location.replace("{{url('admin/categorylist')}}");
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
</script>

@stop