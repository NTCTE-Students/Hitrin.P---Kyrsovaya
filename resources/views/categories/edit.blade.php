@extends('home')

   @section('content')
       <h1>Редактировать категорию</h1>
       <form action="{{ route('categories.update', $category) }}" method="POST">
           @csrf
           @method('PUT')
           <div>
               <label for="name">Название</label>
               <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required>
               @error('name') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <div>
               <label for="description">Описание</label>
               <textarea name="description" id="description">{{ old('description', $category->description) }}</textarea>
               @error('description') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <button type="submit" class="btn btn-primary">Обновить</button>
       </form>
   @endsection