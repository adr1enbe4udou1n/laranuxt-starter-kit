<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    @encoreEntryLinkTags('js/app')

    <!-- Scripts -->
    <script src="//cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.plugins.addExternal('autogrow', '/ckeditor/plugins/autogrow/', 'plugin.js')
        CKEDITOR.plugins.addExternal('image2', '/ckeditor/plugins/image2/', 'plugin.js')
        CKEDITOR.plugins.addExternal('embedbase', '/ckeditor/plugins/embedbase/', 'plugin.js')
        CKEDITOR.plugins.addExternal('embed', '/ckeditor/plugins/embed/', 'plugin.js')
        CKEDITOR.plugins.addExternal('horizontalrule', '/ckeditor/plugins/horizontalrule/', 'plugin.js')
    </script>
    @encoreEntryScriptTags('js/app')
</head>
<body>
    @yield('content')
</body>
</html>
