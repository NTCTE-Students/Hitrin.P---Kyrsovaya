@extends('home')

   @section('content')
       <h1>{{ $category->name }}</h1>
       <p>{{ $category->description ?? 'Нет описания' }}</p>
       <h2>Статьи в категории</h2>
       @if ($articles->isEmpty())
           <p>В этой категории нет статей.</p>
       @else
           @foreach ($articles as $article)
               <div class="card">
                   <h3>{{ $article->title }}</h3>
                   <p>{{ Str::limit($article->content, 100) }}</p>
                   <a href="{{ route('articles.show', $article) }}" class="btn btn-primary">Подробнее</a>
               </div>
           @endforeach
           {{ $articles->links() }}
       @endif
   @endsection