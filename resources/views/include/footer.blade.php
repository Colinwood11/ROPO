<script>
    $(function(){
        if (getCookie("code") != "") {
            $("#sidebar").append("<li class='@if ($sidebar_active == 3) uk-active @endif'><a href='{{ url('/orderlist') }}'>@lang('messages.OrderList')</a></li>");
        } 
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

    function checkAuditTime(beginTime, endTime) {
        var nowDate = new Date(),
            beginDate = new Date(nowDate),
            endDate = new Date(nowDate);

        var beginIndex = beginTime.lastIndexOf("\:");
        var beginHour = beginTime.substring(0, beginIndex);
        var beginMinue = beginTime.substring(beginIndex + 1, beginTime.length);
        beginDate.setHours(beginHour, beginMinue, 0, 0);

        var endIndex = endTime.lastIndexOf("\:");
        var endHour = endTime.substring(0, endIndex);
        var endMinue = endTime.substring(endIndex + 1, endTime.length);
        endDate.setHours(endHour, endMinue, 0, 0);
        if (nowDate.getTime() - beginDate.getTime() >= 0 && nowDate.getTime() <= endDate.getTime()) {
            return true;
        } else {
            return false;
        }
    }
</script>