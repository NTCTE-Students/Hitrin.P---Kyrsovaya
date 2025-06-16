@extends('home')

@section('content')
    <h1>{{ $article->title }}</h1>
    <p>Автор: {{ $article->user->name }}</p>
    <p>Категории: {{ $article->categories->pluck('name')->join(', ') }}</p>
    <p>{{ $article->content }}</p>

    <h2>Комментарии</h2>
    @if($article->comments->isEmpty())
        <p>Комментариев пока нет.</p>
    @else
        @foreach($article->comments as $comment)
            <div>
                <p><strong>{{ $comment->user->name }}</strong> ({{ $comment->created_at->format('d.m.Y H:i') }}):</p>
                <p>{{ $comment->content }}</p>
                @if(auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->isAdmin()))
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Удалить комментарий?')">Удалить</button>
                    </form>
                @endif
            </div>
        @endforeach
    @endif

    @auth
        <h3>Добавить комментарий</h3>
        <form action="{{ route('comments.store', $article) }}" method="POST">
            @csrf
            <textarea name="content" rows="5" cols="50" required></textarea>
            @error('content')
                <p style="color:red;">{{ $message }}</p>
            @enderror
            <button type="submit">Отправить</button>
        </form>
    @endauth
    @guest
        <p>Войдите, чтобы оставить комментарий.</p>
    @endguest
@endsection