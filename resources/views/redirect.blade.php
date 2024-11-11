<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta property="og:title" content="{{ $url->film->title }}">
    <meta property="og:description" content="{{ $url->film->description }}">
    <meta property="og:image" content="{{ $url->film->path_thumbnail }}">
    <meta http-equiv="refresh" content="1;url={{ $url->url }}">
    <title>Redirecting...</title>
</head>
<body>
</body>
</html>
