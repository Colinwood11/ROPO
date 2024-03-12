<div uk-sticky="show-on-up: true; animation: uk-animation-slide-top; sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky; cls-inactive: uk-navbar-transparent;">
    <nav class="uk-navbar uk-navbar-container uk-margin uk-hidden@m">
        <div class="uk-navbar-left">
            <a class="uk-navbar-item uk-logo" href="{{route('AdminIndex')}}">{{ config('app.name', 'Laravel') }}</a>
        </div>
        <div class="uk-navbar-right">
            <a class="uk-navbar-toggle" uk-navbar-toggle-icon href="#m-nav" uk-toggle></a>
        </div>
    </nav>
</div>