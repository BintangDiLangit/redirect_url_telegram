<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta property="og:title" content="{{ $url->title }}">
    <meta property="og:description" content="{{ env('APP_URL') . '/storage/' . $url->banner_image }}">
    <meta property="og:image" content="{{ env('APP_URL') . '/storage/' . $url->banner_image }}">
    <title>Redirecting...</title>
</head>

<body>
    <div id="loading"
        style="display: flex; justify-content: center; align-items: center; height: 100vh; font-family: Arial, sans-serif;">
        <p>Redirecting you to your destination...</p>
    </div>

    <script>
        window.onload = function() {
            setTimeout(function() {
                window.location.href = "{{ $url->url }}";
            }, 100);
        };
    </script>
</body>

</html>
