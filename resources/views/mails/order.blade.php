<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Order Shipped</h1>
    <h3>Product Name: {{$title}}</h3>
    <h4>Order Type: {{$type}}</h4>
    <h3>Price: {{$price}}</h3>
    <h3>
        @if($type == "rent")
            <span>{{$time}}</span>
        @endif

    </h3>
</body>
</html>