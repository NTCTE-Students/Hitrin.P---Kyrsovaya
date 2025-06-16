@extends('home')

   @section('content')
       <h1>Редактировать статью</h1>
       <form method="POST" action="{{ route('articles.update', $article) }}">
           @csrf
           @method('PUT')
           <div>
               <label for="title">Заголовок</label>
               <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" required>
               @error('title') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <div>
               <label for="content">Содержание</label>
               <textarea name="content" id="content" required>{{ old('content', $article->content) }}</textarea>
               @error('content') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <div>
               <label>Категории</label>
               @foreach ($categories as $category)
                   <div>
                       <input type="checkbox" name="categories[]" id="category-{{ $category->id }}" value="{{ $category->id }}"
                           {{ $article->categories->contains($category->id) ? 'checked' : '' }}>
                       <label for="category-{{ $category->id }}">{{ $category->name }}</label>
                   </div>
               @endforeach
               @error('categories') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <button type="submit" class="btn btn-primary">Обновить</button>
       </form>
   @endsection