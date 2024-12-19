@extends('layouts.main')

@section('container')
    <div class="min-h-screen flex flex-col justify-center items-center">
        <h2 class="text-4xl font-bold text-blue-500 text-center mb-5 uppercase">Login <br>To Do List IAM</h2>
        <form class="max-w-lg w-full mx-auto border rounded-lg p-8 shadow-xl" method="POST" action="{{ url('/') }}">
            @csrf
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
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
            <div class="mb-3">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                    password</label>
                <input type="password" id="password" name="password"
                    class="shadow-sm bg-gray-50 border 
                        @error('password') border-red-500 @else border-gray-300 @enderror
                        text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5
                        dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
                        dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light"
                    placeholder="*****" required />
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-5">
                Belum punya akun? <a href="/register" class="text-blue-500 underline">Daftar!</a>
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-full">Login</button>
        </form>
        @if ($errors->has('email') || $errors->has('password'))
            <div id="floating-error"
                class="fixed top-4 right-4 bg-red-600 text-white text-sm px-4 py-2 rounded-lg shadow-lg z-50">
                Email atau password salah, mohon coba lagi.
            </div>
        @else
            <div id="floating-error"
                class="fixed top-4 right-4 bg-green-600 text-white text-sm px-4 py-2 rounded-lg shadow-lg z-50">
                {{ session('success') }}
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const errorBox = document.getElementById('floating-error');
            if (errorBox) {
                setTimeout(() => {
                    errorBox.style.transition = 'opacity 0.5s ease-in-out';
                    errorBox.style.opacity = '0';
                    setTimeout(() => errorBox.remove(), 500); // Hapus elemen setelah animasi selesai
                }, 3000);
            }
        });
    </script>
@endsection
