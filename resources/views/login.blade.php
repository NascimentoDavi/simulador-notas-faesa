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
        <img src="faesa.png" alt="Logo">
        <form action="{{ route('loginPOST') }}" method="POST">
            @csrf

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

            <div class="forgot-password-link">
                <a href="https://acesso.faesa.br/#/auth-user/forgot-password">Esqueceu a senha?</a>
            </div>

        </form>
    </div>

</body>

</html>