@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">
            <h3>Categoria
                <span style="float:right;">
                    <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal(0,'', 0, 0)">Crea Categoria principale</a>
                    <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal(0,'', 1, 0)">Crea Sottocategoria</a>
                </span>
            </h3>
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
                <li class="uk-active"><a href="#" aria-expanded="true">Categoria principale</a></li>
                <li class=""><a href="#" aria-expanded="false">Sottocategoria</a></li>
            </ul>

            <ul class="uk-switcher" style="touch-action: pan-y pinch-zoom;">
                <!-- first list -->
                <li class="uk-active">
                    <table class="uk-table uk-table-striped uk-table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $categorie)
                            <tr>
                                <td>{{$categorie['id']}}</td>
                                <td>{{$categorie['Catname']}}</td>
                                <td>
                                    <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal({{$categorie['id']}},'{{$categorie['Catname']}}', 0, 1,'',{{$categorie['weight']}})"></a>
                                    <a class="uk-button uk-button-primary" uk-icon="trash" onclick="show_modal({{$categorie['id']}},'{{$categorie['Catname']}}', 0, 2,'',{{$categorie['weight']}})"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
                <!-- second list -->
                <li>
                    <table class="uk-table uk-table-striped uk-table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Categoria principale</th>
                                <th>Azione</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sub_categories as $sub_categorie)
                            <tr>
                                <td>{{$sub_categorie['id']}}</td>
                                <td>{{$sub_categorie['name']}}</td>
                                <td>
                                    @isset($sub_categorie['category'])
                                        {{$sub_categorie['category']['Catname']}}
                                    @endisset
                                </td>
                                <td>
                                    <a class="uk-button uk-button-primary" uk-icon="pencil" onclick="show_modal({{$sub_categorie['id']}}, '{{$sub_categorie['name']}}' , 1, 1,'{{$sub_categorie['category']['id']}}','{{$sub_categorie['weight']}}')"></a>
                                    <div class="uk-margin-bottom uk-hidden@m"></div>
                                    <a class="uk-button uk-button-primary" uk-icon="trash" onclick="show_modal({{$sub_categorie['id']}}, '{{$sub_categorie['name']}}' , 1, 2)"></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- This is the categoria-principale modal for insert/modify -->
<div id="modal-categoria-principale" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Categoria principale</h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Nome</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="catname" type="text" placeholder="inserisci il testo...">
                </div>
                <label class="uk-form-label" for="form-h-text">Peso</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="category_weight" type="number" min="0" placeholder="insericsi un numero..">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" type="button" onclick="post_categoria()">Save</button>
        </div>
    </div>
</div>

<!-- This is the sottocategoria modal -->
<div id="modal-sottocategoria" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Categoria principale</h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Nome</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="sottocatname" type="text" placeholder="Some text...">
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-select">Categoria</label>
                <div class="uk-form-controls">
                    <select class="uk-select uk-form-width-large" id="form-h-select">
                        @foreach($categories as $categorie)
                        <option value="{{$categorie['id']}}">{{$categorie['Catname']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Peso</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="subcategory_weight" type="number" min="0" placeholder="insericsi un numero..">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" type="button" onclick="post_categoria()">Save</button>
        </div>
    </div>
</div>

<script>
    var cid = 0;
    var catname = '';
    var cattype = 0;
    var action = 0;

    /*
     * cid        cat或者sottocat的ID  为0则新建
     * catname      编辑时传入的名字   用于显示在编辑框中
     * cattype   0：主Cat  1:子Cat
     * action    0：新增  1：编辑  2：删除
     */

    function show_modal(id1, name1 = "", cattype1, action1, formhselect = "", catweight) {
        cid = id1;
        catname = name1;
        weight = catweight;
        console.log(catweight);
        cattype = cattype1;
        action = action1;

        switch (action) {
            case 0:
                if (cattype == 0) {
                    UIkit.modal(document.getElementById("modal-categoria-principale")).show();
                } else {
                    UIkit.modal(document.getElementById("modal-sottocategoria")).show();
                }
                break;
            case 1:
                if (cattype == 0) {
                    document.getElementById("catname").value = catname;
                    document.getElementById("category_weight").value = weight;
                    UIkit.modal(document.getElementById("modal-categoria-principale")).show();
                } else {
                    document.getElementById("sottocatname").value = catname;
                    document.getElementById("subcategory_weight").value = weight;
                    $("#form-h-select").val(formhselect);
                    UIkit.modal(document.getElementById("modal-sottocategoria")).show();
                }
                break;
            case 2:
                if (cattype == 0) {
                    url = '{{url("api/category/delete")}}';
                } else {
                    url = '{{url("api/subcategory/delete")}}';
                }
                UIkit.modal.confirm('Sei siccuro a cancellare ' + catname + "?").then(function() {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            "id": cid
                        },
                        dataType: "JSON",
                        sync: 'true',
                        success: function(data) {
                            UIkit.modal.alert("OK").then(function() {
                                window.location.replace("{{url('admin/categorylist')}}");
                                console.log(data.responseText)
                                console.log('Alert closed.')
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

                }, function() {
                    console.log('Rejected.')
                });
                break;
            default:
                console.log(`Sorry, we are out of ${action}.`);
        }

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
                        "weight": document.getElementById("category_weight").value
                    }
                } else {
                    url = '{{url("api/subcategory/insert")}}';
                    data = {
                        "name": document.getElementById("sottocatname").value,
                        "Category_id": document.getElementById("form-h-select").value,
                        "weight": document.getElementById("subcategory_weight").value
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
                        "weight": document.getElementById("category_weight").value
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