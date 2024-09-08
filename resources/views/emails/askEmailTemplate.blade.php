<!DOCTYPE html>
<html>
<head>
    <title>Invoice Paid</title>
</head>
<body>
<h1>Hello {{$publisher->name}} !!</h1>

<p>One of the users {{$demander->name}} needs to download the photo</p>


<a href="{{route('DownloadDetails',['image_id'=>$image_id,'demander_id'=>$demander->id])}}">See the Details</a>

<p>Regards, CofaImage</p>
<p>Cofa</p>
</body>
</html>

