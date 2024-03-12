@include('include.header')

<body>
    @include('include.sidebar')

    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slideshow="animation: push">

        <ul class="uk-slideshow-items">
            <li>
                <img src="/images/1.jpeg" alt="" uk-cover>
                <div class="uk-position-center uk-position-small uk-text-center">
                    <h2 uk-slideshow-parallax="x: 100,-100">Benvenuto</h2>
                    <p uk-slideshow-parallax="x: 200,-200">a ristorante !</p>
                </div>
            </li>
            <!-- <li>
            <img src="https://dev.ropp.it/images/2.jpg" alt="" uk-cover>
            <div class="uk-position-center uk-position-small uk-text-center">
                <h2 uk-slideshow-parallax="x: 100,-100">Siamo in fase di sviluppo ancora</h2>
                <p uk-slideshow-parallax="x: 200,-200">XD</p>
            </div>
        </li>
        <li>
            <img src="https://dev.ropp.it/images/3.jpeg" alt="" uk-cover>
            <div class="uk-position-center uk-position-small uk-text-center">
                <h2 uk-slideshow-parallax="x: 100,-100">Benvenuto</h2>
                <p uk-slideshow-parallax="x: 200,-200"></p>
            </div>
        </li> -->
        </ul>

        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous
            uk-slideshow-item="previous"></a>
        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next
            uk-slideshow-item="next"></a>

        <div class="uk-position-bottom-center uk-position-medium">
            <ul class="uk-slideshow-nav uk-dotnav"></ul>
        </div>
    </div>
    @include('include.navbar')
    <div class="uk-section uk-padding-remove-vertical">
        <div class="uk-child-width-1-2@s uk-child-width-1-4@l uk-grid-collapse uk-grid-match" uk-grid>
            <div>
                <div class="uk-tile uk-tile-default">
                    <h3 class="uk-card-title">@lang('messages.card_tittle_1')</h3>
                    <p>@lang('messages.card_text_1')</p>
                </div>
            </div>
            <div>
                <div class="uk-tile uk-tile-muted">
                    <h3 class="uk-card-title">@lang('messages.card_tittle_2')</h3>
                    <p>@lang('messages.card_text_2')</p>
                </div>
            </div>
            <div>
                <div class="uk-tile uk-tile-primary">
                    <h3 class="uk-card-title">@lang('messages.card_tittle_3')</h3>
                    <p>@lang('messages.card_text_3')</p>
                </div>
            </div>
            <!-- <div>
            <div class="uk-tile uk-tile-secondary">
                <h3 class="uk-card-title">@lang('messages.card_tittle_4')</h3>
                <p>@lang('messages.card_text_4')</p>
            </div>
        </div> -->
        </div>
    </div>

</body>

<script>
    window.addEventListener("load", function() {
        /* UIkit.modal.alert('message for stripe <br> This is an online ordering solution for restaurants. <br> The purpose of our application is to sell online.<br>You can use 5795 as the ordering password in this link <a href="https://dev.ropp.it/code">https://dev.ropp.it/code</a>').then(function() {});
     */});
</script>

</html>