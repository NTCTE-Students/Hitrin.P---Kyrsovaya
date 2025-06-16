<!DOCTYPE html>
   <html lang="ru">
   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>Система управления статьями</title>
       <style>
           body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
           nav { background: #333; color: white; padding: 1rem; }
           nav a { color: white; margin: 0 1rem; text-decoration: none; }
           .container { max-width: 1200px; margin: 2rem auto; padding: 0 1rem; }
           .btn { padding: 0.5rem 1rem; border-radius: 5px; text-decoration: none; display: inline-block; }
           .btn-primary { background: #007bff; color: white; }
           .alert { padding: 1rem; margin: 1rem 0; border-radius: 5px; }
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
               <a href="{{ route('logout') }}">Выйти</a>
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
           <h1>Добро пожаловать на наш медицинский форум!</h1>
           <p>Перейдите в раздел <a href="{{ route('articles.index') }}">Статьи</a> или <a href="{{ route('categories.index') }}">Категории</a> для работы с контентом.</p>
       </div>
   </body>
   </html>