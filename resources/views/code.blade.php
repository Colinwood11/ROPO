@include('include.header')

<body>
    @include('include.sidebar')
    @include('include.navbar')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <body class="uk-background-muted">
        <div uk-height-viewport class="uk-section uk-section-small uk-flex uk-flex-middle uk-text-center"
            style="min-height: calc((100vh - 80px) - 0px);">
            <div class="uk-width-1-1">
                <div class="uk-container" style="max-width: 330px;">
                    <p class="uk-text-lead">Inserisci Menu e codice</p>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <div class="uk-form-controls">
                                <label>
                                    <input class="uk-radio" type="radio" name="menu" value="2">
                                    Carta
                                </label>&nbsp;&nbsp;
                                <label>
                                    <input class="uk-radio" type="radio" name="menu" value="4">
                                    Cena(€ 25.90)
                                </label>
                                &nbsp;&nbsp;
                                <label>
                                    <input class="uk-radio" type="radio" name="menu" value="3">
                                    Pranzo(€ 16.90)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <div class="uk-form-controls">
                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                <input class="uk-input" id="code" class="block mt-1 w-full" type="text" name="code"
                                    autocomplete="off" required autofocus placeholder="@lang('messages.Code')">
                            </div>
                        </div>
                    </div>

                    <a class="uk-button uk-button-primary uk-width-1-1"
                        onclick="SubmitCode()">@lang('messages.Confirm')</a>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function(){
            if (checkAuditTime("10:00", "15:00")) {
            $("input[type=radio][name=menu][value=3]").attr("checked",'checked');
        }else if(checkAuditTime("16:00", "23:59")){
            $("input[type=radio][name=menu][value=4]").attr("checked",'checked');
}
});

        function SubmitCode() {
            if ($('#code').val() && $("input[name='menu']:checked").val()) {
                $.ajax({
                    type: 'GET',
                    url: "{{url('api/table/checkcode') }}",
                    data: "code=" + $('#code').val(),
                    dataType: 'json',
                    success: function(data) {
                        UIkit.modal.confirm("@lang('messages.YourTable') " + data.number).then(function() {
                            setCookie('table', data.id, 1);
                            setCookie('code', data.code, 1);
                            setCookie('menu', $("input[name='menu']:checked").val(), 1);
                            window.location.replace("{{route('order')}}");

                        }, function() {
                            console.log('Rejected.')
                        });
                    },
                    error: function(response) {
                        UIkit.modal.confirm("@lang('messages.TableNotFound') ");
                    },
                });
            }else{
                UIkit.modal.alert('Inserisci Menu e codice');
            }
        };

        
    </script>
    @include('include.footer')

    </html>