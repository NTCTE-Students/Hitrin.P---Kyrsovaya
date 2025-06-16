@extends('home')

@section('content')
    <h1>Список статей</h1>
    <form action="{{ route('articles.search') }}" method="GET">
        <input type="text" name="q" placeholder="Поиск по статьям..." value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">Поиск</button>
    </form>
    <form action="{{ route('articles.index') }}" method="GET">
        <select name="category_id">
            <option value="">Все категории</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Фильтр</button>
    </form>
    @foreach ($articles as $article)
        <div class="card">
            <h3>{{ $article->title }}</h3>
            <p>{{ Str::limit($article->content, 100) }}</p>
            <p>Категории: {{ $article->categories->pluck('name')->join(', ') }}</p>
            <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Подробнее</a>
            @auth
                @if (Auth::user()->isAdmin() || Auth::user()->id === $article->user_id)
                    <a href="{{ route('articles.edit', $article) }}" class="btn btn-primary">Редактировать</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить статью?')">Удалить</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach
    {{ $articles->appends(request()->query())->links() }}
@endsection