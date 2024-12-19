@extends('layouts.main')

@section('container')
    <div class="min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-bold text-blue-500 text-center mb-5 uppercase">Register <br>To Do List IAM</h2>
        <form class="max-w-lg w-full mx-auto border rounded-lg p-8 shadow-xl" method="POST" action="{{ url('/register') }}"
            enctype="multipart/form-data">
            @csrf
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name</label>
                <input type="text" id="name" name="name"
                    class="shadow-sm bg-gray-50 border 
                        @error('name') border-red-500 @else border-gray-300 @enderror
                        text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="Your full name" value="{{ old('name') }}" required />
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email
                    Address</label>
                <input type="email" id="email" name="email"
                    class="shadow-sm bg-gray-50 border 
                        @error('email') border-red-500 @else border-gray-300 @enderror
                        text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="example@gmail.com" value="{{ old('email') }}" required />
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                <input type="password" id="password" name="password"
                    class="shadow-sm bg-gray-50 border 
                        @error('password') border-red-500 @else border-gray-300 @enderror
                        text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="*****" required />
                <div id="password-strength-bar" class="flex mt-2">
                    <div class="h-2 flex-1 bg-gray-200 rounded-l"></div>
                    <div class="h-2 flex-1 bg-gray-200"></div>
                    <div class="h-2 flex-1 bg-gray-200 rounded-r"></div>
                </div>
            </div>

            <div class="mb-5">
                <label for="password_confirmation"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="*****" required />
                <p id="password-match" class="mt-2 text-sm"></p>
            </div>
            <div class="mb-5">
                Sudah punya akun? <a href="/" class="text-blue-500 underline">Login!</a>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Register</button>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const passwordStrengthBar = document.getElementById('password-strength-bar').children;


            password.addEventListener('input', () => {
                const value = password.value;
                let strength = 0;


                if (value.length >= 6) strength++;
                if (/[A-Z]/.test(value)) strength++;
                if (/[0-9]/.test(value)) strength++;
                if (/[@$!%*?&#]/.test(value)) strength++;


                for (let i = 0; i < 3; i++) {
                    passwordStrengthBar[i].style.backgroundColor = i < strength ? ['red', 'orange', 'green']
                        [Math.min(2, strength - 1)] : 'gray';
                }
            });
        });
    </script>
@endsection
