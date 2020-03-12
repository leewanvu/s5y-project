<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopify Example</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
    <div class="container vh-100">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-6 w-75">
                <div class="d-flex justify-content-center">
                    <img src="https://img.icons8.com/color/240/000000/shopify.png"/>
                </div>
                <form class="" method="POST" action="{{ route('shopify.install.post') }}">
                    @csrf
                    <div class="form-group">
                        @if(session()->has('message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session()->get('message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <h1 for="shop" class="text-center">Enter the store name</h1>
                        <input type="text" class="form-control" id="shop" name="shop" placeholder="store-name" aria-describedby="shopHelp" value="{{ session()->has('shop') ? session()->get('shop') : '' }}">
                        <small id="shopHelp" class="form-text text-muted">Enter the store name that you want to install this app.</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">INSTALL</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
