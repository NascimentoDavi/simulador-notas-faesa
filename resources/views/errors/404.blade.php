<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Not Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            text-align: center;
            padding: 20px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            max-width: 500px;
            width: 100%;
        }

        .container h1 {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #ff0000;
            margin: 0;
            padding: 0;
        }

        .container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .container a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #2596be;
            color: white;
            border-radius: 5px;
            font-size: 1rem;
        }

        .container a:hover {
            background-color: #7aacce;
        }

        img {
            width: 150px;
            height: 60px;
        }

        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <img class="" src="{{ asset('faesa.png') }}" alt="FAESA LOGO">
        <h1 class="">404</h1>
        <p>Página não encontrada</p>
        <a href="{{ url('/') }}">Login</a>
    </div>
</body>
</html>
