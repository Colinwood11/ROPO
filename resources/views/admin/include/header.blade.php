<!DOCTYPE html>
<title>示例模板-管理后台</title>

<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- UIkit CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/css/uikit.min.css" />

<!-- UIkit JS -->
<script src="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/js/uikit.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/js/uikit-icons.min.js"></script>
<script scr="https://cdn.jsdelivr.net/npm/echarts@4.7.0/dist/echarts.min.js"></script>

<!-- jquery JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
    integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script crossorigin="anonymous" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore.js"></script>

<!-- flexdatalist -->
<!--<script src = "{{resource_path().'/flexdatalist/jquery.flexdatalist.min.js'}}"></script>
<link href="{{resource_path().'/flexdatalist/jquery.flexdatalist.min.css'}}" rel="stylesheet" type="text/css"> -->

<script crossorigin="anonymous" src="{{url('flexdatalist/jquery.flexdatalist.min.js')}}"></script>
<link href="{{url('flexdatalist/jquery.flexdatalist.min.css')}}" rel="stylesheet" type="text/css">

<style type="text/css">
    @media (min-width: 639px) {
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            box-sizing: border-box;
            width: 240px !important;
            padding: 30px 30px 60px 30px;
            background: #223e9c;
            overflow: auto;
        }

        .main {
            padding: 30px 20px 0 260px;
        }
    }
</style>