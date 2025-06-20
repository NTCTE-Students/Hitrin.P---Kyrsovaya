<?php
   namespace App\Http\Controllers\Auth;

   use App\Http\Controllers\Controller;
   use App\Models\User;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Facades\Auth;

   class RegisterController extends Controller
   {
       public function __construct()
       {
           $this->middleware('guest');
       }

       public function showRegistrationForm()
       {
           return view('auth.register');
       }

       public function register(Request $request)
       {
           $data = $request->validate([
               'name' => 'required|string|max:255',
               'email' => 'required|string|email|max:255|unique:users',
               'password' => 'required|string|min:8|confirmed',
           ]);

           $user = User::create([
               'name' => $data['name'],
               'email' => $data['email'],
               'password' => Hash::make($data['password']),
               'role' => 'user', // По умолчанию обычный пользователь
           ]);

           Auth::login($user);
           return redirect()->route('home');
       }
   }