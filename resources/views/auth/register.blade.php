@extends('layouts.auth')

@section('title', __('Register'))

@section('content')
    <div class="p-8">
        <!-- Header -->
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Create Account') }}</h2>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Username') }} <span class="text-red-500">*</span>
                </label>
                <input
                    id="username"
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                    autocomplete="username"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('username') border-red-500 @enderror"
                    placeholder="Choose a username (min 5 characters)"
                >
                <p class="mt-1 text-xs text-gray-500">{{ __('Minimum 5 characters, alphanumeric only') }}</p>
                @error('username')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Email Address') }} <span class="text-red-500">*</span>
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('email') border-red-500 @enderror"
                    placeholder="your.email@example.com"
                >
                <p class="mt-1 text-xs text-gray-500">{{ __('We\'ll create your primary email with this address') }}</p>
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Password') }} <span class="text-red-500">*</span>
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors @error('password') border-red-500 @enderror"
                    placeholder="Minimum 8 characters"
                >
                <p class="mt-1 text-xs text-gray-500">{{ __('At least 8 characters with letters and numbers') }}</p>
                @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    {{ __('Confirm Password') }} <span class="text-red-500">*</span>
                </label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors"
                    placeholder="Re-enter your password"
                >
            </div>

            <!-- Terms Agreement -->
            <div class="flex items-start">
                <input
                    type="checkbox"
                    name="terms"
                    id="terms"
                    required
                    class="w-4 h-4 mt-1 text-primary-600 border-gray-300 rounded focus:ring-primary-500"
                >
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    {{__('I agree to the')}} <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">{{ __('Terms of Service') }}</a>
                    {{ __('and') }} <a href="#" class="text-primary-600 hover:text-primary-700 font-medium">{{ __('Privacy Policy') }}</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5"
            >
                {{ __('Create Account') }}
            </button>
        </form>
    </div>
@endsection

@section('footer-links')
    {{ __('Already have an account?') }}
    <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-700">
        {{ __('Sign in here') }}
    </a>
@endsection
