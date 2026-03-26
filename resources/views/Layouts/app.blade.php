<!DOCTYPE html>
<html lang="ur" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>شوبا نظام</title>

    <!-- Global CSS -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <!-- Optional: Tailwind CSS if used -->
    <!-- <link href="{{ mix('css/output.css') }}" rel="stylesheet"> -->
</head>
<body class="bg-gray-100 font-sans">

    <!-- Vue mount point -->
    <div id="app">
        <!-- Vue Router will render pages here -->
        <router-view></router-view>
    </div>

    <!-- JS Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>