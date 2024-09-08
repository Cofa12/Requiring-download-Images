<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        img{
            width: 800px;
            height: 400px;
            display: block;
            margin: auto;
            margin-top:60px;
        }
        a{
            width: 82px;
            height: 35px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            background-color: forestgreen;
            color: #e5e7eb;
            border-radius: 12%;
            margin: auto;
            margin-top: 50px;

        }
    </style>
</head>
<body>

    <img src="http://127.0.0.1:8000/storage/{{json_decode($image_url)}}">
    <a href="{{route('confirm',['image_url'=>json_decode($image_url),'demander_id'=>$demander_id])}}"> Confirm</a>
</body>
</html>
