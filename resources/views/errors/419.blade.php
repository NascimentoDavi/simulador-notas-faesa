<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sessão expirada</title>
    <link rel="icon" type="image/png" href="faesa_favicon.png">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loginScreen.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
    .container {
        max-width: 400px;
        margin: 50px auto;
        padding: 40px;
        background-color: white;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .container img {
        max-width: 100%;
        margin-bottom: 30px;
    }

    .alert-expired {
        color: #721c24;
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .btn-login-again {
        background-color: #2596be;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-decoration: none;
        display: inline-block;
    }

    .btn-login-again:hover {
        background-color: #1b6e91;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-login-again:active {
        transform: translateY(1px);
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }
</style>

<body>
    <div class="container">
        <!-- LOGO -->
        <img src="{{ asset('faesa.png') }}" alt="Logo FAESA">

        <!-- Mensagem de Sessão Expirada -->
        <div class="alert-expired">
            <strong>Sessão expirada.</strong><br>
            Sua sessão foi encerrada ou o tempo expirou.<br>
            Por favor, faça login novamente.
        </div>

        <!-- Botão para redirecionar -->
        <a href="{{ route('logoutAndClear') }}" class="btn-login-again">Voltar para o Login</a>
    </div>
</body>
</html>
