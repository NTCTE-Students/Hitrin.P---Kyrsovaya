@extends('home')

@section('content')
    <h1>Создать статью</h1>
    <form action="{{ route('articles.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">Заголовок</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title') <span class="alert alert-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="content">Содержимое</label>
            <textarea name="content" id="content" required>{{ old('content') }}</textarea>
            @error('content') <span class="alert alert-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Категории</label>
            @foreach ($categories as $category)
                <div>
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                    <label>{{ $category->name }}</label>
                </div>
            @endforeach
            @error('categories') <span class="alert alert-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection