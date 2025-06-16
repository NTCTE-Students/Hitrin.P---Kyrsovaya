<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управления статьями</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        nav { background: #333; color: white; padding: 1rem; }
        nav a, nav form { color: white; margin: 0 1rem; text-decoration: none; display: inline-block; }
        nav button { background: none; border: none; color: white; cursor: pointer; font-size: 16px; }
        .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
        .card { background: white; padding: 1rem; margin: 1rem 0; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .card h3 { margin: 0 0 0.5rem; }
        .btn { padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
        .alert { padding: 1rem; margin: 1rem 0; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        @media (max-width: 768px) { .container { padding: 0 0.5rem; } }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('welcome') }}" style="font-weight: bold; font-size: 1.2rem;">Медицина Плюс</a>
        <a href="{{ route('welcome') }}">Главная</a>
        <a href="{{ route('articles.index') }}">Статьи</a>
        <a href="{{ route('categories.index') }}">Категории</a>
        @auth
            @if (Auth::user()->is_admin)
                <a href="{{ route('categories.create') }}">Создать категорию</a>
            @endif
            <a href="{{ route('articles.create') }}">Создать статью</a>
            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit">Выйти</button>
            </form>
        @else
            <a href="{{ route('login') }}">Войти</a>
            <a href="{{ route('register') }}">Регистрация</a>
        @endauth
    </nav>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </div>
</body>
</html>