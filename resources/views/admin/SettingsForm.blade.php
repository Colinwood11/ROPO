@extends('admin.template')
@section('content')


<div class="uk-card uk-card-default">
    <div class="uk-card-body">
        <div class="uk-container uk-margin uk-grid" uk-grid>
            @php
                $hedear = null;
                if (isset($settings['checkout_header'])) {
                    $hedear = $settings['checkout_header'];
                    unset($settings['checkout_header']);
                }
            @endphp
            @foreach($settings as $setting)
                <div class="uk-first-column uk-width-1-5">
                    <label class="uk-form-label" for="form-h-text" style="color: #666;">@lang('messages.'.$setting->name)</label>
                </div>
                <div class="uk-form-controls uk-width-2-5">
                    <input class="uk-input uk-form-width-large" id="{{$setting->name}}_value" type="text" name="name" placeholder="value" value="{{$setting->value}}">
                </div>
                <div class="uk-form-controls uk-width-2-5">
                    <a class="uk-button uk-button-primary" onclick="UpdateSetting('{{$setting->name}}')" target="_blank"><i uk-icon="check"></i></a>
                </div>
            @endforeach
                <div class="uk-first-column uk-width-1-5">
                    <label class="uk-form-label" for="form-h-text" style="color: #666;">@lang('messages.'.$hedear['name'])</label>
                </div>
                <div class="uk-form-controls uk-width-2-5">
                    <textarea class="uk-textarea uk-form-width-large" id="{{$hedear['name']}}_value" type="text" name="name" rows = "5" placeholder="value">{{$hedear['value']}} </textarea>
                </div>
                <div class="uk-form-controls uk-width-2-5">
                    <a class="uk-button uk-button-primary" onclick="UpdateSetting('{{$hedear['name']}}')" target="_blank"><i uk-icon="check"></i></a>
                </div>
                
                <label class="uk-form-label" for="form-h-text" style="color: #666;">同步环境</label>
                <div class="uk-form-controls">
                    <a class="uk-button uk-button-primary" href="http://194.163.176.203:8888/hook?access_key=A47jVZLIbhHTvpXcPlaZRcBNXsIrsaHQAlDBpYnGpWChlYTg&param=aaa" target="_blank">开发--》测试</a>
                </div>
            <hr class="uk-divider-small">
            <!-- <div class="uk-panel uk-column-1-1 uk-column-1-2@m">
                <div class="uk-column-1-1">
                    <a class="uk-button uk-button-primary">Reset</a>
                </div>
                <div class="uk-column-1-1">
                    <a class="uk-button uk-button-primary">Submit</a>
                </div>
            </div> -->
        </div>
    </div>
</div>
<script>

var SETTINGS_ATTRIBUTE = @json($settings_name);

function UpdateSetting(name) {

        value = document.getElementById(name+'_value').value;

        $.ajax({
            url: "{{ Route('SettingsUpdate') }}",
            type: "POST",
            timeout: 3000,
            data: {
                "name": name,
                "value": value
            },
            dataType: "JSON",
            sync: 'true',
            success: function(data) {
                console.log(data);
                UIkit.modal.alert('Aggiornamento dell\'impostazione con successo').then(function() {
                    console.log('Alert closed.')
                    window.location.reload();
                });
            },
            error: function(data) {
                UIkit.modal.alert(`Error! chieti a assistenza <br> Error data:<em> ${data.responseText}</em>`).then(function() {
                    console.log(data.responseText)
                    console.log('Alert closed.')
                });
            }
        });
    }

</script>


<hr class="uk-divider-icon uk-margin-medium">
<!--@lang('messages.description')-->
@stop