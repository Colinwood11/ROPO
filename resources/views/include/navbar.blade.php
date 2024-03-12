<body>
    @if ($fix_position_top == 1) <div class="uk-position-relatie">
        <div class="uk-position-top"> @endif
            <div
                uk-sticky="show-on-up: true; animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky;  @if ($navbar_transparent == 1) cls-inactive: uk-navbar-transparent uk-light; top:200; @endif">
                <nav class="uk-navbar-container" uk-navbar uk-margin>
                    <div class="uk-navbar-left">
                        <ul class="uk-navbar-nav">
                            @if ($menu_list ?? '' )
                            <li>
                                <a aria-expanded="true">
                                    <span class="uk-margin-small-right uk-badge" id='menu' style="height:42px">Scegli
                                        Menu</span>
                                </a>
                                <div class="uk-navbar-dropdown"
                                    uk-drop="mode: click; cls-drop: uk-navbar-dropdown; boundary: !nav; flip: x">
                                    <ul class="uk-nav uk-dropdown-nav">
                                        @foreach ($menu_list as $menu)
                                        <li>
                                            <a id="menu{{$menu->id}}"
                                                onclick="Change_menu({{$menu->id}},'{{$menu->name}}')">
                                                {{$menu->name}}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            @else
                            <a class="uk-navbar-toggle" uk-toggle="target: #offcanvas-push">
                                <span class="uk-margin-small-right"></span> <span uk-navbar-toggle-icon></span>
                            </a>
                            @endif

                        </ul>
                    </div>
                    <div class="uk-navbar-center">
                        <ul class="uk-navbar-nav">
                            <a class="uk-navbar-item uk-logo" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}
                                <img src="" alt="">
                                <img class="uk-logo-inverse" src="" alt=""></a>
                        </ul>
                    </div>

                    <div class="uk-navbar-right">
                        <div class="uk-navbar-item">
                            <ul class="uk-navbar-nav">
                                <li>
                                    <a uk-toggle="target: #push-cart">
                                        <i uk-icon="icon: cart"></i>
                                        <span class="uk-badge" id="cart_number">0</span>
                                    </a>
                                    <!-- <div class="uk-navbar-dropdown" uk-drop="mode: click; cls-drop: uk-navbar-dropdown; boundary: !nav; flip: x">
                                        <ul class="uk-nav uk-dropdown-nav">
                                            <li><a href="{{ route('register') }}"><span uk-icon="user"></span> {{ __('messages.Register') }}</a></li>
                                            
                                        </ul>
                                    </div> -->
                                </li>

                                <!-- <li>
                                    <a uk-icon="icon: user"></a>
                                    <div class="uk-navbar-dropdown" uk-drop="mode: click; cls-drop: uk-navbar-dropdown; boundary: !nav; flip: x">
                                        <ul class="uk-nav uk-dropdown-nav">
                                            @if (Route::has('login'))
                                            @auth
                                            <li><a href="{{ url('/dashboard') }}">{{ __('待定已登录文本') }}</a></li>
                                            @else
                                            <li><a href="{{ route('login') }}"><span uk-icon="sign-in"></span> {{ __('messages.Login') }}</a></li>
                                            @if (Route::has('register'))
                                            <li><a href="{{ route('register') }}"><span uk-icon="user"></span> {{ __('messages.Register') }}</a></li>
                                            @endif
                                            @endauth
                                            @endif
                                             <li class="uk-nav-divider"></li>
                                            <li><a><span uk-icon="world"></span> @lang('messages.Language')</a>
                                                <div class="uk-navbar-dropdown" uk-drop="mode: click; cls-drop: uk-navbar-dropdown; boundary: !nav; flip: x">
                                                    <ul class="uk-nav uk-dropdown-nav">
                                                        <li><a data-testid="link-language-en_US" href="/login"><span>English (US)</span></a></li>
                                                        <li><a data-testid="link-language-zh_CN" href="/login"><span>简体中文(China)</span></a></li>
                                                        <li><a data-testid="link-language-it_IT" href="/login"><span>Italiano (Italy)</span></a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li> -->
                            </ul>
                        </div>

                    </div>
                </nav>
            </div>
            @if ($fix_position_top == 1)
        </div>
    </div>@endif