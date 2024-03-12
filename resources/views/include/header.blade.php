<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 设置IOS全屏APP -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>{{$tittle ?? ''}} - {{ config('app.name', 'Laravel') }}</title>

    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/css/uikit.min.css" />

    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.7.0/dist/js/uikit-icons.min.js"></script>

    <!-- jquery JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <!-- Underscore JS (sort) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore.js"></script>

</head>