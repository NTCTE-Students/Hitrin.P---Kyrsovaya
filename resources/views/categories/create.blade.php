@extends('home')

@section('content')
    <h1>Создать категорию</h1>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <div>
            <label for="name">Название</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name') <span class="alert alert-danger">{{ $message }}</span> @enderror
        </div>
        <div>
            <label for="description">Описание</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
            @error('description') <span class="alert alert-danger">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Создать</button>
    </form>
@endsection