<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Batata</title>

    </head>
    <body>
        @foreach ($categorias as $item)
        <span style="color:black">{{$item->titulo}}</span>

        @endforeach

    </body>
</html>
