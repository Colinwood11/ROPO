@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">


        <div class="uk-grid-margin uk-first-column" uk-filter="target: .js-filter">
            <h3>Table List
                <span style="float:right;">
                </span>
            </h3>

            <ul class="uk-subnav uk-subnav-pill">
                <li class="uk-active" uk-filter-control><a href="#">Tutto</a></li>
                <li uk-filter-control="[data-tags*='0']"><a href="#">Libero</a></li>
                <li uk-filter-control="[data-tags*='1']"><a href="#">In servizio</a></li>
            </ul>

            <ul class="js-filter uk-child-width-1-3 uk-child-width-1-6@m uk-text-center uk-margin" uk-grid>
                @foreach($tables as $table)
                @if($table['status'] == 0)
                <li data-tags="0">
                    <a onclick="show_modal_ativazione({{$table['id']}} , '{{$table['number']}}', {{$table['num_person']}})">
                        <div class="uk-card uk-card-default uk-card-body">
                            {{$table['number']}}
                        </div>
                    </a>
                </li>
                @elseif($table['status'] == 1)
                <li data-tags="1">
                    <a href="{{route('GetTableWithHistory',['id'=>$table['id']])}}">
                        <div class="uk-card uk-card-primary uk-card-body" style="padding-top: 30px;padding-right: 0px;padding-bottom: 30px;padding-left: 0px;">
                            Tav:{{$table['number']}}
                            <br>
                            <{{$table['code']}}>
                                <br>
                                {{$table['table_history'][0]["num_person"]}}P.
                                <br>
                                ({{\Carbon\Carbon::parse($table['table_history'][0]["start_time"])->format('H:i')}})
                        </div>
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- This is the sottocategoria modal -->
<div id="modal-ativazione" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title" id="tittle"></h2>
        </div>
        <div class="uk-modal-body">
            <div class="uk-margin">
                <label class="uk-form-label" for="form-h-text">Persone</label>
                <div class="uk-form-controls">
                    <input class="uk-input uk-form-width-large" id="number" type="text" placeholder="Write a number...">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" type="button" onclick="post_attivazione()">Save</button>
        </div>
    </div>
</div>
<script language="JavaScript">
    function myrefresh() {
        window.location.reload();
    }
    setTimeout('myrefresh()', 20000); //指定20秒刷新一次 
</script>
<script>
    var tid = 0;

    /*
     * tid        TAVOLO的ID
     */

    function show_modal_ativazione(id1, name, number) {
        tid = id1;
        document.getElementById("number").value = number;
        document.getElementById("tittle").innerHTML = "Attiva il tavolo <<" + name + ">>";
        UIkit.modal(document.getElementById("modal-ativazione")).show();

    }

    function post_attivazione() {

        $.ajax({
            url: '{{url("api/table/activate")}}',
            type: "POST",
            data: {
                "id": tid,
                "num_person": document.getElementById("number").value
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                window.location.replace("{{url('admin/tablelist')}}");
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