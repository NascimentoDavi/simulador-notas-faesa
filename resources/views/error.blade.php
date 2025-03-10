<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
    <script>
        let count = 5;
        function updateCountdown() {
            document.getElementById("countdown").innerText = count;
            if (count > 1) {
                count--;
                setTimeout(updateCountdown, 1000); // Atualiza a cada 1 segundo
            } else {
                window.location.href = "{{ route('login') }}"; // Redireciona para login após 5s
            }
        }
        window.onload = updateCountdown;
    </script>
</head>
<body>
    <div>
        <h2>Erro</h2>
        <p>Nenhuma matrícula encontrada para este aluno.</p>
        <p>Você será redirecionado para a tela de login em <span id="countdown">5</span> segundos...</p>
    </div>
</body>
</html>
