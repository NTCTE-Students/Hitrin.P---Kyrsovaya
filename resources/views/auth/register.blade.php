@extends('home')

   @section('content')
       <h1>Регистрация</h1>
       <form method="POST" action="{{ route('register') }}">
           @csrf
           <div>
               <label for="name">Имя</label>
               <input type="text" name="name" id="name" value="{{ old('name') }}" required>
               @error('name') <span class="alert alert-danger">{{ $message }}</span> @enderror
           </div>
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
           <div>
               <label for="password_confirmation">Подтверждение пароля</label>
               <input type="password" name="password_confirmation" id="password_confirmation" required>
           </div>
           <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
       </form>
   @endsection