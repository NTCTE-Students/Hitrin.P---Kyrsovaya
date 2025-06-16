@extends('home')

@section('content')
    <h1>Список категорий</h1>
    @auth
        @if (Auth::user()->isAdmin())
            <a href="{{ route('categories.create') }}" class="btn btn-primary">Создать категорию</a>
        @endif
    @endauth
    @if ($categories->isEmpty())
        <p>Категорий пока нет.</p>
    @else
        @foreach ($categories as $category)
            <div class="card">
                <h3>{{ $category->name }}</h3>
                <p>{{ $category->description ?? 'Нет описания' }}</p>
                <a href="{{ route('categories.show', $category) }}" class="btn btn-primary">Подробнее</a>
                @auth
                    @if (Auth::user()->isAdmin())
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Редактировать</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить категорию?')">Удалить</button>
                        </form>
                    @endif
                @endauth
            </div>
        @endforeach
    @endif
@endsection