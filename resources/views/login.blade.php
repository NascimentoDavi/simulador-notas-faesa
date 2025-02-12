<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loginScreen.css') }}" />
    <title>Login</title>
    <link rel="icon" type="image/png" href="faesa_favicon.png">

</head>

<body>
    <div class="container">
        <img src="faesa.png" alt="Logo" {{-- method="POST" --}}>
        <form action="{{ route('login') }}">
            @csrf <!-- evitar erros de token -->

            <label for="login">Usuário</label>
            <input type="text" id="login" name="login" required>
            <div class="hr">
                <hr>
            </div>
            @error('login')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="senha">Senha</label>
            <input type="password" id="senha" name="senha" required>
            <div class="hr">
                <hr>
            </div>
            @error('senha')
            <div class="error">{{ $message }}</div>
            @enderror

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <input type="submit" value="Entrar">
        </form>
    </div>

</body>

</html>