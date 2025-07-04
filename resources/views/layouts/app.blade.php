{{-- Basic App Structure --}}

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>

    {{-- Favicon -Icon- --}}
    <link rel="icon" type="image/png" href="/favicon.png">

    {{-- Custom CSS Sets --}}
    @vite('resources/css/app.css')

    {{-- Bootsrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous">
    </script>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>@yield('title') - FAESA</title>
</head>

<body class="bg-main-color poppins-light">

    <!--

    Jesus
     
    
    
    te
    
    
    
    ama!
    
    -->

    <!-- NAVBAR -->
    @include('layouts.navbar')

    <!-- CONTEUDO PRINCIPAL -->
    <div class="container-fluid mt-2 mb-1">
        @yield('content')
    </div>

    <!-- SECAO DE SIMULACAO DE NOTA -->
    @include('layouts.formula-calc')
    
    <!-- FOOTER -->
    @include('layouts.footer')

</body>

<script>
    let timeout;

    function resetTimer() {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            window.location.href = "{{ route('logout') }}"; // Rota do logout
        }, 30 * 60 * 1000); // 30 minutos de inatividade
    }

    // Dispara o resetTimer ao carregar e ao detectar atividade do usuário
    window.onload = resetTimer;
    document.onmousemove = resetTimer;
    document.onkeypress = resetTimer;
</script>


</html>