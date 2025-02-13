{{-- Basic App Structure --}}

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - FAESA</title>
</head>

<body>

    <header>Default Header</header>

    @yield('content')
    
    <footer>Default Footer</footer>

</body>

</html>