<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; height: 100vh; overflow: hidden; margin: 0; }
            .auth-container { display: flex; height: 100vh; }
            .auth-form { flex: 1; display: flex; align-items: center; justify-content: center; padding: 40px; background: #fff; }
            .auth-visual { flex: 1; display: flex; align-items: center; justify-content: center; color: white; text-align: center; padding: 40px; }
            .form-box { width: 100%; max-width: 400px; }
            .form-control { border-radius: 12px; padding: 14px 20px; border: 1px solid #e0e0e0; }
            .btn-auth { padding: 14px; border-radius: 12px; font-weight: 600; }

            @keyframes slideInLeft { from { opacity: 0; transform: translateX(-50px); } to { opacity: 1; transform: translateX(0); } }
            @keyframes slideInRight { from { opacity: 0; transform: translateX(50px); } to { opacity: 1; transform: translateX(0); } }
            .slide-in-left { animation: slideInLeft 0.8s ease-out; }
            .slide-in-right { animation: slideInRight 0.8s ease-out; }

            @media (max-width: 768px) { .auth-visual { display: none; } }
        </style>
    </head>
    <body>
        <div class="auth-container">
            {{ $slot }}
        </div>
    </body>
</html>
