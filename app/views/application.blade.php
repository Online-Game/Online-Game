<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="http://192.168.253.56/online-game/public/css/style.css">
    <script type="text/javascript" src="http://192.168.253.56/online-game/public/jquery-2.1.4.min.js"></script>
    <script src="http://192.168.33.11:12345/socket.io/socket.io.js"></script>
</head>

<body>
@yield('content')
</body>

@yield('script')

</html>
