<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta property="og:title" content="{{ $url->title }}">
    <meta property="og:image" content="{{ env('APP_URL_STREAMING') . $url->banner_image }}">
    <meta http-equiv="refresh" content="1;url={{ $url->url }}">
    <title>Redirecting...</title>
</head>

<body>
</body>

</html>
