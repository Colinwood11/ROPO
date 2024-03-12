@extends('admin.template')
@section('content')

<div class="uk-card uk-card-default">
    <div class="uk-card-body">

        <div class="uk-grid-margin uk-first-column">
            <h3>Dish List</h3>
            <table class="uk-table uk-table-striped uk-table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Numero</th>
                        <th>Nome</th>
                        <th>Stato</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dishes as $dish)
                    <tr>
                        <td>{{$dish['id']}}</td>
                        <td>@isset($dish['code']){{$dish['code']}}@endisset{{$dish['number_code']}}</td>
                        <td>{{$dish['name']}}</td>
                        <td class="uk-preserve-width">{{$dish['status']}}</td>
                        <td class="uk-preserve-width">
                            <a class="uk-button uk-button-primary" href="{{Route('getDishForm',$dish['id'])}}" uk-icon="pencil"></a>
                            <div class="uk-margin-bottom uk-hidden@m"></div>
                            <a class="uk-button uk-button-primary" onclick="DeleteConfirm({{$dish['id']}})" uk-icon="trash"></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr class="uk-divider-icon uk-margin-medium">
<!--@lang('messages.description')-->
<script>

var dishes = @json($dishes);

function DeleteConfirm(id) {
    console.log(dishes);
    UIkit.modal.confirm("@lang('messages.DeleteDishConfirm')" + dishes[id]['name']).then(function() {
        console.log('Confirmed.');
        AjaxDeleteDish(id);
    }, function() {
        console.log('Rejected.')
    });
}

function AjaxDeleteDish(id) {

$.ajax({
    url: "{{Route('ApiDishDelete')}}",
    type: "DELETE",
    data: {
        "id": id,
    },
    dataType: "JSON",
    sync: 'true',
    success: function(data) {
        UIkit.modal.alert('Operazione successo con l\'esito <br>' + data.message).then(function() {
            window.location.reload();
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
}

</script>
@stop