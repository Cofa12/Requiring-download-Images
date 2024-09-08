<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        a{
            width: 82px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            background-color: forestgreen;
            color: #FFF;
            border-radius: 12%;
            margin: auto;
            margin-top: 50px;

        }
    </style>
</head>
<body>
<h1>the publisher confirmed to download the image with Title <b>{{$image->title}}</b></h1>
{{--<img src="http://127.0.0.1:8000/storage/"{{$image->image_url}}>--}}
<a style="color:#e5e7eb;justify-content: center;align-items: center;text-decoration: none;: #e5e7eb" href="{{route('download',['image_path'=>$image->image_url])}}">Download</a>
</body>
</html>
