@extends('home')

   @section('content')
       <h1>Вход</h1>
       <form method="POST" action="{{ route('login') }}">
           @csrf
           <div>
               <label for="email">Email</label>
               <input type="email" name="email" id="email" value="{{ old('email') }}" required>
               @error('email') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <div>
               <label for="password">Пароль</label>
               <input type="password" name="password" id="password" required>
               @error('password') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
           <button type="submit" class="btn btn-primary">Войти</button>
       </form>
   @endsection