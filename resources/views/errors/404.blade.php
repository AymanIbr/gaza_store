<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <style>
        .btn-404 {
            background-color: #dd3d31;
            padding: 10px 20px;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #fff;
            border-radius: 5px;
            font-family: sans-serif;
            font-size: 20px;
            transition: all .3s ease
        }

        .btn-404:hover {
            background-color: #f56055;
        }
    </style>
</head>

<body style="text-align: center">
    <img style="height: 80vh; display:block; margin:0 auto" src="{{ asset('assets/img/404.svg') }}" alt="">
    <a class="btn-404" href="/">Back To Home</a>
</body>

</html>
