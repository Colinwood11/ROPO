@extends('admin.template')
@section('content')
<div class="uk-child-width-1-1 uk-grid-match" uk-grid>
	<div>

		<div class="uk-card uk-card-default">
			<div class="uk-card-body">
				<a class="uk-button uk-button-primary" onclick="testPost()" uk-icon="pencil">Who Am I?</a>
				<a class="uk-button uk-button-primary" onclick="logout()" uk-icon="pencil">Logout</a>
			</div>
		</div>

	</div>
</div>

<script>
	function testPost() {
		$.ajax({
			url: "{{Route('testPost')}}",
			type: "POST",
			data: {},
			dataType: "JSON",
			sync: 'true',
			success: function(data) {
				console.log(data);
				UIkit.modal.alert('Modificato con successo').then(function() {
					console.log(data.responseText);
					console.log('Alert closed.');
					//window.location.reload();
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