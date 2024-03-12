@include('include.header')

<body>
    @include('include.sidebar')
    @include('include.navbar')


    <body class="uk-background-muted">
        <div uk-height-viewport class="uk-section uk-section-small uk-flex uk-flex-middle uk-text-center" style="min-height: calc((100vh - 80px) - 0px);">
            <div class="uk-width-1-1">
                <div class="uk-container" style="max-width: 330px;">
                    <p><svg width="90" height="83" viewBox="0 0 168 155" xmlns="http://www.w3.org/2000/svg" style="color: rgb(30,135,240);" class=" uk-svg" data-svg="/skin/ukv3/images/uikit-logo-large.svg">
                            <path fill="#fff" d="M117.4 33.3L93.3 47.9l27.8 15.8v41.5L83.8 126l-36.7-20.8V73L23 60.7v58.9l59.9 35.2 62.1-35.2V49.2l-27.6-15.9zM106.2 27.5L82.9 14 58.6 29.1l23.6 13z"></path>
                        </svg></p>
                    <p class="uk-text-lead">{{ __('Log in') }}</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="uk-margin">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: user"></span>
                                <input class="uk-input" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="{{ __('Email') }}">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-inline uk-width-1-1">
                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                <input class="uk-input" type="password" placeholder="" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password">
                            </div>
                        </div>
                        <div class="uk-margin">
                            <div class="uk-inline">
                                <label><input class="uk-checkbox" type="checkbox"> {{ __('Remember me') }}</label>
                            </div>
                        </div>
                        <button class="uk-button uk-button-primary uk-width-1-1">{{ __('Log in') }}</button>
                        <p class="uk-margin-medium-top	">
                        &copy; 2021 ROP <br> Product by DUE PICCIONI <br> Powered by <a href="*">Laravel </a>  </p>
                    </form>
                </div>
            </div>

        </div>
    </body>

    </html>