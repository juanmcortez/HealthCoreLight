@extends('layouts.auth')

@section('title', __('Register'))

@section('content')
    <div class="p-8">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('Forgot Password?') }}</h2>
            <p class="mt-2 text-sm text-gray-600">{{ __('No problem. Just let us know your email address and we\'ll email you a password reset link.') }}</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Email Address') }}
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 @enderror"
                    placeholder="your.email@example.com"
                >
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
            >
                {{ __('Email Password Reset Link') }}
            </button>
        </form>
    </div>
@endsection

@section('footer-links')
    {{ __('Remember your password?') }}
    <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700">
        {{ __('Back to login') }}
    </a>
@endsection
