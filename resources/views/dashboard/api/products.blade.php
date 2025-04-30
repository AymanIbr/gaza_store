<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Api Products</title>
</head>

<body>
    <div class="container">
        <h2>Products From API</h2>
        <table class="table">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Price</th>
                <th>Rating</th>
            </tr>
            @foreach ($products as $product)
            <tr>
                {{-- array --}}
                <th>{{ $product['id'] }}</th>
                <th>{{ $product['title'] }}</th>
                <th>
                    <img width="90" src="{{ $product['thumbnail'] }}" alt="">
                </th>
                <th>{{ $product['description'] }}</th>
                <th>{{ $product['price'] }}</th>
                <th>{{ $product['rating'] }}</th>
            </tr>
            @endforeach
        </table>
    </div>
</body>

</html>
