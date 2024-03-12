<script>
    window.addEventListener("load", function() {
        
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i].trim();
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    }

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 6 * 60 * 60 * 1000));
        var expires = "expires=" + d.toGMTString();
        document.cookie = cname + "=" + cvalue + "; path=/; " + expires;
    }
    
    function logout() {
		$.ajax({
			url: "{{Route('logout')}}",
			type: "POST",
			data: {},
			dataType: "JSON",
			sync: 'true',
			success: function(data) {
				console.log(data);
				UIkit.modal.alert('Modificato con successo').then(function() {
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
</script>