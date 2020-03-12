<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store Not Support</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>The {{ request()->get('name', 'store-name') }} is not support {{ request()->get('scope', implode(', ', config('shopify.scopes'))) }}</h1>
                <a href="/">Go back</a>
            </div>
        </div>
    </div>
</body>
</html>
