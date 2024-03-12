<div id="offcanvas-push" uk-offcanvas="mode: push">
    <div class="uk-offcanvas-bar uk-flex uk-flex-column uk-text-center">
        <button class="uk-offcanvas-close uk-close-large" type="button" uk-close></button>
        <ul class="uk-nav uk-nav-primary uk-nav-center uk-margin-auto-vertical uk-nav-parent-icon" uk-nav id="sidebar">
            <li class="@if ($sidebar_active == 1) uk-active @endif"><a href="{{ url('/') }}">@lang('messages.Home')</a></li>
            <li class="@if ($sidebar_active == 2) uk-active @endif"><a href="{{ url('/order') }}">@lang('messages.Order')</a></li>
            <!--li class="@if ($sidebar_active == 3) uk-active @endif"><a href="{{ url('/') }}">@lang('messages.booking')</a></li-->
        </ul>
        <div>
            <div class="uk-grid-small uk-child-width-auto uk-flex-inline" uk-grid>
                <!--div>
                    <a class="uk-icon-button" href="#" uk-icon="icon: facebook"></a>
                </div>
                <div>
                    <a class="uk-icon-button" href="#" uk-icon="icon: twitter"></a>
                </div>
                <div>
                    <a class="uk-icon-button" href="#" uk-icon="icon: mail"></a>
                </div-->
                <div>
                    <a class="uk-icon-button" href="tel:0736780180" uk-icon="icon: receiver"></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="push-cart" uk-offcanvas="mode: push; flip: true;overlay:true">
    <div class="uk-offcanvas-bar">
    <button class="uk-offcanvas-close" type="button" uk-close></button>
        <ul class="uk-nav uk-nav-default">
            <li>
                <h3><span class="uk-margin-small-right" uk-icon="icon: cart"></span>Carello</h3>
            </li>
            <li>
                <button class="uk-button uk-button-secondary" onclick="SubmitOrder()">Conferma Ordine</button>
            </li>
            <li class="uk-nav-header">Ordine</li>
            <ul id="cart-area-id">

            </ul>
        </ul>
    </div>
</div>
